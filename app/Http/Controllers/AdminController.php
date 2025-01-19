<?php

namespace App\Http\Controllers;

use ConstGuards;
use ConstDefaults;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginHandler(Request $request) {
        $filedType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if($filedType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:admins,email',
                'password' => 'required|min:5|max:45'
            ],[
                'login_id.required' => 'Email or Username is required',
                'login_id.email' => 'Invalid Email Address',
                'login_id.exists' => 'Email is not exists in the system',
                'password.required' => 'Password is required'
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:admins,username',
                'password' => 'required|min:5|max:45'
            ],[
                'login_id.required' => 'Email or Username is required',
                'login_id.exists' => 'Username is not exists in the system',
                'password.required' => 'Password is required'
            ]);
        }

        $creds = array(
            $filedType => $request->login_id,
            'password' => $request->password
        );

        if(Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('admin.home');
        } else {
            session()->flash('fail', 'Invalid Credentials');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request) {
        Auth::guard('admin')->logout();
        session()->flash('success', 'Successfully');
        return redirect()->route('admin.login');
    }

    public function sendPasswordResetLink(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ],[
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid Email Address',
            'email.exists' => 'The :attribute is not exists in system'
        ]);

        //Get admin Details
        $admin = Admin::where('email', $request->email)->first();

        //Generate Tokens
        $token = base64_encode(Str::random(64));

        //check if there is an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
                    ->where(['email'=>$request->email, 'guard'=>constGuards::ADMIN])
                    ->first();

        if($oldToken) {
            //update existing token
            DB::table('password_reset_tokens')
                ->where(['email'=>$request->email, 'guard'=>constGuards::ADMIN])
                ->update([
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
        } else {
            //add new token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        $actionLink = route('admin.reset-password', ['token' => $token, 'email' => $request->email]);

        $data = array(
            'actionLink' => $actionLink,
            'admin' => $admin
        );

        $mailBody = view('email-templates.admin-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Reset Password',
            'mail_body' => $mailBody
        );

        if(sendEmail($mailConfig)) {
            session()->flash('success', 'Successfully');
            return redirect()->route('admin.forgot-password');
        } else {
            session()->flash('fail', 'Swomething went wrong');
            return redirect()->route('admin.forgot-password');
        }
    }

    public function resetPassword(Request $request, $token = null) {

        $check_token = DB::table('password_reset_tokens')
                        ->where(['token'=>$token, 'guard'=>constGuards::ADMIN])
                        ->first();

        if($check_token) {
            //check if token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if($diffMins > constDefaults::tokenExpiredMinutes) {
                //if token is expired
                session()->flash('fail', 'Token Expired!');
                return redirect()->route('admin.forgot-password',['token' => $token]);
            } else {
                return view('back.pages.admin.auth.reset-password')->with(['token'=>$token]);
            }
        } else {
            session()->flash('fail', 'Invalid token!');
            return redirect()->route('admin.forgot-password',['token' => $token]);
        }
    }

    public function resetPasswordHandler(Request $request) {
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'
        ]);

        $token = DB::table('password_reset_tokens')
                    ->where(['token'=>$request->token, 'guard'=>constGuards::ADMIN])
                    ->first();

        //get admin details
        $admin = Admin::where('email', $token->email)->first();

        //update password
        Admin::where('email', $admin->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        //Delete token record
        DB::table('password_reset_tokens')->where([
            'email'=>$admin->email,
            'token'=>$request->token,
            'guard'=>constGuards::ADMIN
        ])->delete();

        //send email to admin
        $data = array(
            'admin'=>$admin,
            'new_password'=>$request->new_password
        );

        $mail_body = view('email-templates.admin-reset-password-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Password Changed',
            'mail_body' => $mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('admin.login')->with('pass', 'Sucessfully');

    }

    public function profileView(Request $request) {
        $admin = null;
        if(Auth::guard('admin')->check()){
            $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.pages.admin.profile', compact('admin'));
    }

    public function changeProfilePicture(Request $request) {
        $admin = Admin::findOrFail(auth('admin')->id());
        $path = 'images/users/admins/';
        $file = $request->file('adminProfilePicturFile');
        $old_picture = $admin->getAttributes()['picture'];
        $file_path = $path.$old_picture;
        $filename = 'ADMIN_IMG_'.rand(2,1000).$admin->id.time().uniqid().'.jpg';

        $upload = $file->move(public_path($path), $filename);

        if($upload) {
            if($old_picture != null && File::exists(public_path($path.$old_picture))) {
                File::delete(public_path($path.$old_picture));
            }
            $admin->update(['picture'=>$filename]);
            return response()->json(['status'=>1, 'msg'=>'Profile picture uploaded successfully']);
        } else {
            return response()->json(['status'=>0, 'msg'=>'Something went wrong.']);
        }
    }

    public function changeLogo(Request $request) {
        $path = 'images/site/';
        $file = $request->file('site_logo');
        $settings = new GeneralSetting();
        $old_logo = $settings->first()->site_logo;
        $file_path = $path.$old_logo;
        $filename = 'LOGO'.uniqid().'.'.$file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);

        if($upload) {
            if($old_logo != null && File::exists(public_path($path.$old_logo))) {
                File::delete(public_path($path.$old_logo));
            }
            $settings = $settings->first();
            $settings->site_logo = $filename;
            $update = $settings->save();

            return response()->json(['status' => 1, 'msg' => 'Site Logo Updated Successfully']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function changeFavicon(Request $request) {
        $path = 'images/site/';
        $file = $request->file('site_favicon');
        $settings = new GeneralSetting();
        $old_favicon = $settings->first()->site_favicon;
        $file_path = $path.$old_favicon;
        $filename = 'FAV'.uniqid().'.'.$file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);

        if($upload) {
            if($old_favicon != null && File::exists(public_path($path.$old_favicon))) {
                File::delete(public_path($path.$old_favicon));
            }
            $settings = $settings->first();
            $settings->site_favicon = $filename;
            $update = $settings->save();

            return response()->json(['status' => 1, 'msg' => 'Site Favicon Updated Successfully']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong']);
        }
    }
}
