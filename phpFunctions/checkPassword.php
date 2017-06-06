<?php
        echo "bin hier";
        var_dump($_SESSION);
        var_dump($_SERVER);
        include_once " ./classes/securitas.class.php";

    if($_POST['incoming_userAut']){
        $password = json_decode(stripslashes($_POST['incoming_userAut']));
//        $sec = new securitas();

        $username = $_SESSION['user'];
//        if($sec->checkLogin($username, $password){
//            echo "Passwort stimmt";
//        }

    }
