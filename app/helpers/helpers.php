<?php

use App\Models\SocialNetwork;
use App\Models\GeneralSetting;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/** SEND EMAIL USING PHP EMAILER FUNCTION **/

if(!function_exists('sendEmail')) {
    function sendEmail($mailConfig) {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = env('EMAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('EMAIL_USERNAME');
        $mail->Password = env('EMAIL_PASSWORD');
        $mail->SMPTSecure = env('EMAIL_ENCRYPTION');
        $mail->Port = env('EMAIL_PORT');
        $mail->setFrom($mailConfig['mail_from_email'],$mailConfig['mail_from_name']);
        $mail->addAddress($mailConfig['mail_recipient_email'],$mailConfig['mail_recipient_name']);
        $mail->isHTML(true);
        $mail->Subject = $mailConfig['mail_subject'];
        $mail->Body = $mailConfig['mail_body'];
        if($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}

/** Get General Settings Data **/

if(!function_exists('get_settings')) {
    function get_settings() {
        $results = null;
        $settings = new GeneralSetting();
        $settings_data = $settings->first();

        if($settings_data) {
            $results = $settings_data;
        } else {
            $settings->insert([
                'site_name' => 'MultiVendor E-commerce',
                'site_email' => 'info@multiecom.com'
            ]);
            $new_settings_data = $settings->first();
            $results = $new_settings_data;
        }
        return $results;
    }
}

/** Get Social Network Data **/

if(!function_exists('get_social_network')) {
    function get_social_network() {
        $results = null;
        $social_netork = new SocialNetwork();
        $social_netork_data = $social_netork->first();

        if($social_netork_data) {
            $results = $social_netork_data;
        } else {
            $social_netork->insert([
                'facebook_url' => null,
                'twitter_url' => null,
                'instagram_url' => null,
                'youtube_url' => null,
                'github_url' => null,
                'linkedin_url' => null,
            ]);

            $new_social_netork_data = $social_netork->first();
            $results = $new_social_netork_data;
        }
        return $results;
    }
}


/** Front end Helpers **/

//Get Categories

if(!function_exists('get_categories')) {
    function get_categories(){
        $categories = Category::with('subcategories')->orderBy('ordering', 'asc')->get();
        return !empty($categories) ? $categories : [];
    }
}
