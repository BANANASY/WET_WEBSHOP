<?php
require_once "./classes/securitas.class.php";

echo "<p class='bg-info'>I'm here.</p>";
if (!empty($_POST["username"])) {
    $sec = new securitas();
    if ($sec->checkString16($_POST["username"])) {
        $username = $_POST["username"];
        if ($sec->checkPassword($_POST["password"])) {
            $password = $_POST["password"];
            if ($sec->checkLogin($username, $password)) {
                echo "<p class='bg-success'>Welcome young Bananjero. You are logged in.</p>";
                //write to session
                //weiterleiten zu produkten
//            if set $_POST["cookie"]
//            cookie setzen
            }
        }
    } else {
        echo "<p class='bg-danger'>Password missmatch. Enter a valid password between 8 and 16 characters wide. Alphanumeric.</p>";
    }
} else {
    echo "<p class='bg-danger'>Username missmatch. Enter a valid username.</p>";
}
?>

<div class="col-md-12 div_login">
    <div class="col-md-5 div_login" id="div_login_left">

        <form action="?page=7" method="post">
            <h4>Existing Customer</h4>
            <div class="form-group">
                <label for="username">Username</label>
                <input name="username" type="text" class="form-control" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name= "password" type="password" class="form-control" id="password" required>
            </div>
            <div class="checkbox">
                <label>
                    <input name="cookie" type="checkbox" value="Remember me">
                </label>
            </div>
            <button type="submit" class="btn btn-default">Login</button>
        </form>
    </div>

    <div class="col-md-1" id="div_login_middle"></div>

    <div class="col-md-5 div_login" id="div_login_right">
        <div id="div_login_right_inner">
            <h4>You must be new around here!</h4>
            <p>Click this banana to register!</p>
            <a href="?page=8"> <img id="goRegister" src="./pictures/banana_button.jpg"></a>
        </div>            
    </div>
</div>


