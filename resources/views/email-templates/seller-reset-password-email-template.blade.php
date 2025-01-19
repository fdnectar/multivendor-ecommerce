<p>Dear {{ $seller->name }}</p>
<br>
<p>Your password has been changed successfully.
    Here is your new login credentials.
    <br>
    <b>Login Id: </b> {{ $seller->email }}
    <br>
    <b>Password: </b> {{ $new_password }}
</p>
Please keep your credentials confidential. Never share your login details with anybody else.

<p>
    We are not responsible for any misuse of your username or password.
</p>

<br>
------------------------------------------------------------------

<p>
    This is system generated email, do not reply.
</p>
