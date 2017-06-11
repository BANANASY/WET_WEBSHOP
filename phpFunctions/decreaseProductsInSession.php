<?php

INCLUDE '../classes/product.class.php';

session_start();

if($_POST['decreasing_product']){
        $newEntry = json_decode(stripslashes($_POST['decreasing_product']));
        $newEntry = $newEntry + 0;

        // check if session already has shopping cart
        if(isset($_SESSION['shoppingcart'])){
            //check if product already exists in shoppingcart
            for($i = 1;$i < sizeof($_SESSION['shoppingcart']);$i++){
                if($_SESSION['shoppingcart'][$i]->getId() === $newEntry){                                      
                    //decrease found product
                    $_SESSION['shoppingcart'][$i]->priceDecrease(1);
                    $_SESSION['shoppingcart'][$i]->countDecrease(1);
                    
                    //also decrease all_products
                    $price_single = $_SESSION['shoppingcart'][$i]->getPriceSingle();
                    
                    $_SESSION['shoppingcart'][0]->countDecrease(1);
                    $_SESSION['shoppingcart'][0]->priceDecreaseAll($price_single);
                    
                    if($_SESSION['shoppingcart'][$i]->getCount() === 0){
                        // if count equals zero delete product from product array
                        array_splice($_SESSION['shoppingcart'],$i,1);
                    }        
                    
                    if(count($_SESSION['shoppingcart']) === 1){
                        unset($_SESSION['shoppingcart']);
                    }                       
                }
            }
        }           
    }


