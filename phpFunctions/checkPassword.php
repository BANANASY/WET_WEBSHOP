<?php

//ajax file zur überprüfung des Passworts. Der username wird aus der session gehohlt, das pw kommt per poST über ajax.

session_start();
require_once '../classes/securitas.class.php';

if (!empty($_POST['pw'])) {
    if (!empty($_SESSION['user'][0])) {
        $username = $_SESSION['user'][0];
        $sec = new securitas();
        $password = $_POST['pw'];
        if ($sec->checkLogin($username, $password)) {
            echo "passed";
        }
    }
} else {
    echo "bullshit";
}
