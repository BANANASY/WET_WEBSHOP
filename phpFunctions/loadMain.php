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
        default:
            include 'sites/main/404.php';
    }
}
