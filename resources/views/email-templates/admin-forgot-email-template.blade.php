<p>Dear {{ $admin->name }}</p>
<p>
    We have recieved a request to reset the password for Multivendor Ecommerce Platform account associated with {{ $admin->email }}.
    You cane reset your password by clicking the button below.
    <br>
    <a href="{{ $actionLink }}" target="_blank" style="margin-top: 15px; margin-bottom: 15px; color: #fff;border-color: #5156be; border-style:solid; border-width: 5px 10px;
    background-color: #5156be; display: inline-block; text-decoration: none; border-radius: 3px;
    box-shadow: box-shadow: 0 2px 6px 0 rgba(81, 86, 190, .5); -webkit-text-size-adjust: none; box-sizing: border-box;">Reset Password</a>
    <br>
    <b>NB:</b> This link will valid within 15 minutes.
    <br>
    If you did not request  for a password reset, please ignore this email.
</p>
