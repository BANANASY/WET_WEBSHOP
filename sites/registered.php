<?php

require_once './classes/user.class.php';
require_once './classes/DB.class.php';

if (!empty($_POST)) {
    $anrede = $_POST['salutation'];
    $vorname = $_POST['firstName'];
    $nachname = $_POST['lastName'];
    $strasse = $_POST['adress'];
    $plz = $_POST['zip'];
    $ort = $_POST['place'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $zid = $_POST['credit'];

    $newUser = new user($anrede, $vorname, $nachname, $email, $strasse, $plz, $ort, $username, $password1, $password2, $zid);
    if ($newUser->addToDB()) {
        echo "User registered successfully. Enjoy your banana shopping experience";
    } else {
        echo "Not registered. Something went wrong. Try again! Good luck next time.";
    }
} else {
    echo "Holy Bananoes!? What the hell are you doing here?";
}
