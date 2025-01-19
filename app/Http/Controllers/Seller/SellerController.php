<?php

namespace App\Http\Controllers\Seller;

use ConstGuards;
use ConstDefaults;
use App\Models\Shop;
use App\Models\Seller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\VerificationToken;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function login(Request $request) {
        $data = [
            'pageTitle' => 'Seller Login'
        ];
        return view('back.pages.seller.auth.login', $data);
    }

    public function register(Request $request) {
        $data = [
            'pageTitle' => 'Create Seller Account'
        ];
        return view('back.pages.seller.auth.register', $data);
    }

    public function home(Request $request) {
        $data = [
            'pageTitle' => 'Seller Dashboard'
        ];
        return view('back.pages.seller.home', $data);
    }

    public function createSeller(Request $request) {
        // dd("Create Seller Account");
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:sellers,email',
            'password' => 'required|min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:5'
        ]);

        $seller = new Seller();
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->password = Hash::make($request->password);
        $saved = $seller->save();

        if($saved) {
            //Generate token
            $token = base64_encode(Str::random(64));

            VerificationToken::create([
                'user_type'=> 'seller',
                'email' => $request->email,
                'token' => $token
            ]);

            $actionLink = route('seller.verify', ['token' => $token]);
            $data['action_link'] = $actionLink;
            $data['seller_name'] = $request->name;
            $data['seller_email'] = $request->email;

            $mail_body = view('email-templates.seller-verify-template', $data)->render();

            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $request->email,
                'mail_recipient_name' => $request->name,
                'mail_subject' => 'Verify Seller Account',
                'mail_body' => $mail_body
            );

            if(sendEmail($mailConfig)) {
                return redirect()->route('seller.register-success');
            } else {
                return redirect()->route('seller.register')->with('fail', 'Something went wrong while sending verification link');
            }

        } else {
            return redirect()->route('seller.register')->with('fail', 'Something went wrong');
        }
    }

    public function verifyAccount(Request $request, $token) {
        $verifyToken = VerificationToken::where('token', $token)->first();
        if(!is_null($verifyToken)) {
            $seller = Seller::where('email', $verifyToken->email)->first();
            if(!$seller->verified) {
                $seller->verified = 1;
                $seller->email_verified_at = Carbon::now();
                $seller->save();
                return redirect()->route('seller.login')->with('success', 'Your email is verified. You can now login');
            } else {
                return redirect()->route('seller.login')->with('info', 'Your email is already verified. You can now login');
            }
        } else {
            return redirect()->route('seller.register')->with('fail', 'Invalid Token');
        }
    }

    public function registerSuccess(Request $request) {
        return view('back.pages.seller.register-success');
    }

    public function loginHandler(Request $request) {

        $filedType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if($filedType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:sellers,email',
                'password' => 'required|min:5|max:45'
            ],[
                'login_id.required' => 'Email or Username is required',
                'login_id.email' => 'Invalid Email Address',
                'login_id.exists' => 'Email is not exists in the system',
                'password.required' => 'Password is required'
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:sellers,username',
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

        if(Auth::guard('seller')->attempt($creds)) {
            // return redirect()->route('seller.home');
            if(!auth('seller')->user()->verified) {
                auth('seller')->logout();
                return redirect()->route('seller.login')->with('fail', 'Your account is not verified. please check your email');
            } else {
                return redirect()->route('seller.home');
            }

        } else {
            session()->flash('fail', 'Invalid Credentials');
            return redirect()->route('seller.login');
        }
    }

    public function logoutHandler(Request $request) {
        Auth::guard('seller')->logout();
        session()->flash('success', 'Logged Out Successfully');
        return redirect()->route('seller.login');
    }

    public function forgotPassword(Request $request) {
        $data = [
            'pageTitle' => 'Forgot Password'
        ];
        return view('back.pages.seller.auth.forgot-password');
    }

    public function sendPasswordResetLink(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:sellers,email'
        ],[
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid Email Address',
            'email.exists' => 'The :attribute is not exists in system'
        ]);

        //Get admin Details
        $seller = Seller::where('email', $request->email)->first();

        //Generate Token
        $token = base64_encode(Str::random(64));

        //check if old token exist
        $old_token = DB::table('password_reset_tokens')
                    ->where(['email' => $seller->email, 'guard' => ConstGuards::SELLER])
                    ->first();

        if($old_token) {
            //update existing token
            DB::table('password_reset_tokens')
                ->where(['email'=>$seller->email, 'guard'=>constGuards::SELLER])
                ->update([
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
        } else {
            //add new token
            DB::table('password_reset_tokens')->insert([
                'email' => $seller->email,
                'guard' => constGuards::SELLER,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        $actionLink = route('seller.reset-password', ['token' => $token, 'email' => urlencode($seller->email)]);

        $data = array(
            'actionLink' => $actionLink,
            'seller' => $seller
        );

        $mailBody = view('email-templates.seller-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $seller->email,
            'mail_recipient_name' => $seller->name,
            'mail_subject' => 'Reset Password',
            'mail_body' => $mailBody
        );

        if(sendEmail($mailConfig)) {
            session()->flash('success', 'Successfully');
            return redirect()->route('seller.forgot-password');
        } else {
            session()->flash('fail', 'Swomething went wrong');
            return redirect()->route('seller.forgot-password');
        }
    }

    public function showResetForm(Request $request, $token = null) {

        $check_token = DB::table('password_reset_tokens')
                        ->where(['token'=>$token, 'guard'=>constGuards::SELLER])
                        ->first();

        if($check_token) {
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());
            if($diffMins > constDefaults::tokenExpiredMinutes) {
                //if token is expired
                session()->flash('fail', 'Token Expired!');
                return redirect()->route('seller.forgot-password',['token' => $token]);
            } else {
                return view('back.pages.seller.auth.reset-password')->with(['token'=>$token]);
            }

        } else {
            session()->flash('fail', 'Invalid token!');
            return redirect()->route('seller.forgot-password',['token' => $token]);
        }
    }

    public function resetPasswordHandler(Request $request) {
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'
        ]);

        $token = DB::table('password_reset_tokens')
                    ->where(['token'=>$request->token, 'guard'=>constGuards::SELLER])
                    ->first();

        //get seller details
        $seller = Seller::where('email', $token->email)->first();

        //update password
        Seller::where('email', $seller->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        //Delete token record
        DB::table('password_reset_tokens')->where([
            'email'=>$seller->email,
            'token'=>$request->token,
            'guard'=>constGuards::SELLER
        ])->delete();

        //send email to admin
        $data = array(
            'seller'=>$seller,
            'new_password'=>$request->new_password
        );

        $mail_body = view('email-templates.seller-reset-password-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $seller->email,
            'mail_recipient_name' => $seller->name,
            'mail_subject' => 'Password Changed',
            'mail_body' => $mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('seller.login')->with('pass', 'Sucessfully');
    }

    public function profileView(Request $request) {
        $data = [
            'pageTitle' => 'Seller Profile Page',
            'seller' => null
        ];

        if(Auth::guard('seller')->check()){
            $data['seller'] = Seller::findOrFail(auth()->id());
        }

        return view('back.pages.seller.profile', $data);
    }

    public function changeProfilePicture(Request $request) {
        $seller = Seller::findOrFail(auth('seller')->id());
        $path = 'images/users/sellers/';
        $file = $request->file('sellerProfilePicturFile');
        $old_picture = $seller->getAttributes()['picture'];
        $file_path = $path.$old_picture;
        $filename = 'SELLER_IMG_'.rand(2,1000).$seller->id.time().uniqid().'.jpg';

        $upload = $file->move(public_path($path), $filename);

        if($upload) {
            if($old_picture != null && File::exists(public_path($path.$old_picture))) {
                File::delete(public_path($path.$old_picture));
            }
            $seller->update(['picture'=>$filename]);
            return response()->json(['status'=>1, 'msg'=>'Seller Profile picture uploaded successfully']);
        } else {
            return response()->json(['status'=>0, 'msg'=>'Something went wrong.']);
        }
    }

    public function shopSettings(Request $request) {

        $seller = Seller::findOrFail(auth('seller')->id());
        $shop = Shop::where('seller_id', $seller->id)->first();
        $shopInfo = '';

        if(!$shop) {
            //create shop if not exist
            Shop::Create(['seller_id' => $seller->id]);
            $nshop = Shop::where('seller_id', $seller->id)->first();
            $shopInfo = $nshop;
        } else {
            $shopInfo = $shop;
        }

        $data = [
            'pageTitle' => 'Seller Shop Settings',
            'shopInfo' => $shopInfo
        ];

        return view('back.pages.seller.shop-settings', $data);
    }

    public function shopSetup(Request $request) {
        $seller = Seller::findOrFail(auth('seller')->id());
        $shop = Shop::where('seller_id', $seller->id)->first();
        $old_logo_img = $shop->shop_logo;
        $logo_name = '';
        $path = 'images/shop/';

        $request->validate([
            'shop_name' => 'required|unique:shops,shop_name,'.$shop->id,
            'shop_phone' => 'required|numeric',
            'shop_address' => 'required',
            'shop_description' => 'required',
            'shop_logo' => 'nullable|mimes:jpeg,png,jpg,',
        ]);

        if($request->hasFile('shop_logo')) {
            $file = $request->file('shop_logo');
            $filename = 'SHOPLOGO_'.$seller->id.uniqid().'.'.$file->getClientOriginalExtension();
            $upload = $file->move(public_path($path), $filename);

            if($upload) {
                $logo_name = $filename;

                //delete existing logo
                if($old_logo_img != null && File::exists(public_path($path.$old_logo_img))) {
                    File::delete(public_path($path.$old_logo_img));
                }
            }
        }

        //update shop details
        $data = array(
            'shop_name' => $request->shop_name,
            'shop_phone' => $request->shop_phone,
            'shop_address' => $request->shop_address,
            'shop_description' => $request->shop_description,
            'shop_logo' => $logo_name != null ? $logo_name : $old_logo_img,
        );

        $update = $shop->update($data);

        if($update) {
            return redirect()->route('seller.shop-settings')->with('success', 'Shop info updated successfully');
        } else {
            return redirect()->route('seller.shop-settings')->with('fail', 'Something went wrong');
        }
    }
}
