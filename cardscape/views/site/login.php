<form id="login" name="login" method="post" action="?login_submit">
    <fieldset><legend>Login</legend>
        <input type="text" name="user" id="user" /><label for="name">Username</label><br />
        <input type="password" name="pass" id="pass" /><label for="pass">Password</label><br />
        <input type="hidden" name="js_on" id="js_on" value="0" />
        <input type="submit" value="Login" />
        <a href="?register">Register?</a>
    </fieldset>
</form>

<form id="register" name="register" method="post" action="?register_submit">
    <fieldset><legend>Register new account</legend>
        <input type="text" name="user" id="user" /><label for="name">Username</label><br />
        <input type="password" name="pass" id="pass" /><label for="pass">Password</label><br />
        <input type="password" name="pass2" id="pass2" /><label for="pass2">Password (repeat)</label><br />
        <input type="text" name="mail" id="mail" /><label for="mail">E-Mail adress</label><br />
        <input type="submit" value="Register" />
        <a href="?login">Login?</a> TODO: ReCaptcha
    </fieldset>
</form>
