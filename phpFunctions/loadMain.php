<?php

function loadMain($page) {
    switch ($page) {
        case 0:
            include 'sites/main/home.php';
            break;
        case 1:
            include 'sites/main/produkte.php';
            break;
        case 2:
            include 'sites/main/meinkonto.php';
            break;
        case 3:
            include 'sites/main/warenkorb.php';
            break;
        case 4:
            include 'sites/main/editProducts.php';
            break;
        case 5:
            include 'sites/main/editCustomers.php';
            break;
        case 6:
            include 'sites/main/editGut.php';
            break;
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
        default:
            include 'sites/main/404.php';
    }
}
