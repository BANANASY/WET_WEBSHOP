<?php
// simply returns how many products are currently saved within the shopping cart

INCLUDE '../classes/product.class.php';
session_start();


if($_SESSION['shoppingcart']){
    echo "".$_SESSION['shoppingcart'][0]->getCount();
}

