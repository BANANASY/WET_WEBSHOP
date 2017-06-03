<?php

INCLUDE '../classes/product.class.php';

    if($_POST['incoming_product']){
        $newEntry = json_decode(stripslashes($_POST['incoming_product']));
        $newEntry = $newEntry + 0;
        $heinzwald = array();
       
        if(!isset($_SESSION['shoppingcart'])){
            echo "'shoppingcart' nicht gesetzt<br/>";
            $heinzwald = array_push($heinzwald, $newEntry);
            $_SESSION['shoppingcart'] = $heinzwald;
        }else{
            echo "'shoppingcart' gesetzt<br/>";
            $heinzwald = $_SESSION['shoppingcart'];
            array_push($heinzwald, $newEntry);
            $_SESSION['shoppingcart'] = $heinzwald;
        }
        
        echo count($_SESSION['shoppingcart']);
        var_dump($heinzwald);
        var_dump($_SESSION);
    }
