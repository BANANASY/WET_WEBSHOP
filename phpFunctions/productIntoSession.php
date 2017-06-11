<?php

INCLUDE '../classes/product.class.php';

// this file adds only one product per call into the session either by a JQuery drop event or by
// a click on 'In den Warenkorb legen'.

session_start();

    if($_POST['incoming_product']){
        $newEntry = json_decode(stripslashes($_POST['incoming_product']));
        $newEntry = $newEntry + 0;
        $productExists = false;

        // check if it is the first entry for this session
        if(!isset($_SESSION['shoppingcart'])){
            $_SESSION['shoppingcart'] = array();
            $_SESSION['shoppingcart'][0] = new product(-1, 1);
            
            $_SESSION['shoppingcart'][1] = new product($newEntry, 1);
            $price_single = $_SESSION['shoppingcart'][1]->getPriceSingle();
            $_SESSION['shoppingcart'][0]->priceIncreaseAll(1, $price_single);
        }else{
            //check if product already exists in shoppingcart
            for($i = 1;$i < sizeof($_SESSION['shoppingcart']);$i++){
                if($_SESSION['shoppingcart'][$i]->getId() === $newEntry){
                    $_SESSION['shoppingcart'][$i]->countIncrease(1);
                    $_SESSION['shoppingcart'][$i]->priceIncrease(1);
                    $price_single = $_SESSION['shoppingcart'][$i]->getPriceSingle();
                    
                    //also increase all_products
                    $_SESSION['shoppingcart'][0]->countIncrease(1);
                    $_SESSION['shoppingcart'][0]->priceIncreaseAll(1, $price_single);
                    $productExists = true;
                }
            }
            // if product doesnt exist, add to session as new product object
            if(!$productExists){
                $newProduct = new product($newEntry, 1);
                $price_single = $newProduct->getPriceSingle();
                $_SESSION['shoppingcart'][] = $newProduct;
                $_SESSION['shoppingcart'][0]->countIncrease(1);
                $_SESSION['shoppingcart'][0]->priceIncreaseAll(1, $price_single);
            }
        }
        
        //TESTING STUFF:
//        echo "<br/>************************************ <b>NEW CALL</b> ************************************";
//        echo "<br/>Sent ID: ".$newEntry."<br/>";
//        echo "count session['shoppingcart']: ".count($_SESSION['shoppingcart'])."<br/>";
//        echo "max_count in array: ".$_SESSION['shoppingcart'][0]->getCount()."<br/>";
//        echo "------------------------------------------------------------------------<br/>";
//        
//        for($i = 1;$i < sizeof($_SESSION['shoppingcart']);$i++){
//            echo "Index ".$i."<br/>";
//            if(isset($_SESSION['shoppingcart'][$i])){
//                echo "################<br/>";
//                echo ".......p_id: ".$_SESSION['shoppingcart'][$i]->getId()."<br/>";
//                echo ".......desc: ".$_SESSION['shoppingcart'][$i]->getName();
//                echo "......count: ".$_SESSION['shoppingcart'][$i]->getCount()."<br/>";
//                echo "...priceAll: ".$_SESSION['shoppingcart'][$i]->getPriceAll()."<br/>";
//                echo "priceSingle: ".$_SESSION['shoppingcart'][$i]->getPriceSingle()."<br/>";
//                echo "################<br/>";
//                
//            }
//        }
//        
//        echo "<br/>------ all_products stats --------<br/>";
//        echo "......p_id: ".$_SESSION['shoppingcart'][0]->getId();
//        echo ".....count: ".$_SESSION['shoppingcart'][0]->getCount();
//        echo ".....price: ".$_SESSION['shoppingcart'][0]->getPriceAll();
//        
    }
    
