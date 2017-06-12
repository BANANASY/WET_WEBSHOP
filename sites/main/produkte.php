<?php
include 'sites/warenkorb_symbol.php';
include 'inc/nav_sec.php';
//include 'classes/DB.class.php';

$DB = new DB();


if (empty($_GET['kat'])) {
    $DB->getProductsByCategory(1);
} else {
    $DB->getProductsByCategory($_GET['kat']);
}
?>