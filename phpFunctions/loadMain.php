<?php

function loadMain($page) {
    if (!empty($_SESSION)) {
        $user = $_SESSION['user'];
        $role = $user[1];
    } else {
        $role = "visitor";
    }
    switch ($page) {
        case 0:
            include 'sites/main/home.php';
            break;
        case 1:
            include 'sites/main/produkte.php';
            break;
        case 2:
            if ($role === 'user') {
                include 'sites/main/meinkonto.php';
            } else {
                include 'sites/main/notAuthorized.php';
            }break;
        case 3:
            include 'sites/main/warenkorb.php';
            break;
        case 4:
            if ($role === 'admin') {
                include 'sites/main/editProducts.php';
            } else {
                include 'sites/main/notAuthorized.php';
            }break;
        case 5:
            if ($role === 'admin') {
                include 'sites/main/editCustomers.php';
            } else {
                include 'sites/main/notAuthorized.php';
            }break;
        case 6:
            if ($role === 'admin') {
                include 'sites/main/editGut.php';
            } else {
                include 'sites/main/notAuthorized.php';
            }break;
        case 7:
            include 'sites/login.php';
            break;
        case 8:
            include 'sites/register.php';
            break;
        case 9:
            include 'dbConnectiontest.php';
            break;
        case 10:
            include 'sites/registered.php';
            break;
        case 11:
            include 'sites/main/goodbye.php';
            break;
        case 12:
            if ($role === 'admin') {
                include 'sites/main/addProduct.php';
            } else {
                include 'sites/main/notAuthorized.php';
            }break;
        case 13:
            if ($role === 'admin') {
                include 'sites/main/addGut.php';
            } else {
                include 'sites/main/notAuthorized.php';
            }break;
        default:
            include 'sites/main/404.php';
    }
}
