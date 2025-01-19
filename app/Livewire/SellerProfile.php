<?php

namespace App\Livewire;

use App\Models\Seller;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerProfile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'=>['keep'=>true]];
    public $name, $email, $username, $phone, $address, $seller_id;
    public $current_password, $new_password, $new_password_confirmation;

    public function selectTab($tab) {
        $this->tab = $tab;
    }

    public function mount() {
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        if(Auth::guard('seller')->check()) {
            $seller = Seller::findOrFail(auth()->id());
            $this->seller_id = $seller->id;
            $this->name = $seller->name;
            $this->email = $seller->email;
            $this->username = $seller->username;
            $this->phone = $seller->phone;
            $this->address = $seller->address;
        }
    }

    public function updateSellerPersonalDetails() {
        $this->validate([
            'name' => 'required|min:5',
            'username' => 'required|min:3|unique:admins,username,'.$this->seller_id
        ]);

        Seller::find($this->seller_id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->dispatch('updateAdminSellerHeaderInfo');
        $this->dispatch('updateSellerInfo', [
            'sellerName' => $this->name,
            'sellerEmail' => $this->email
        ]);
        $this->showToaster('success', 'Seller Personal Details Updated Successfully');
    }

    public function updatePassword() {
        $this->validate([
            'current_password' => [
                'required', function($attribute, $value, $fail) {
                    if(!Hash::check($value, Seller::find(auth('seller')->id())->password)) {
                        return $fail(__('The current password is incorrect'));
                    }
                }
            ],
            'new_password' =>'required|min:5|max:45|confirmed'
        ]);

        $query = Seller::findOrFail(auth('seller')->id())->update([
            'password' => Hash::make($this->new_password)
        ]);

        if($query) {

            $_seller = Seller::findOrFail($this->seller_id);

            $data = array(
                'seller'=>$_seller,
                'new_password'=>$this->new_password
            );

            $mail_body = view('email-templates.seller-reset-password-email-template', $data)->render();

            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $_seller->email,
                'mail_recipient_name' => $_seller->name,
                'mail_subject' => 'Password Changed',
                'mail_body' => $mail_body
            );

            sendEmail($mailConfig);

            $this->current_password = $this->new_password = $this->new_password_confirmation = null;
            $this->showToaster('success', 'Password changed successfully');
        } else {
            $this->showToaster('danger', 'Something went wrong.');
        }
    }

    public function showToaster($type, $message) {
        return $this->dispatch('showToaster',[
            'type' => $type,
            'message' => $message
        ]);
    }


    public function render()
    {
        return view('livewire.seller-profile', [
            'seller' => Seller::findOrFail(auth('seller')->id())
        ]);
    }
}
