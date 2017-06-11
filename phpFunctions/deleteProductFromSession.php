<?php

INCLUDE '../classes/product.class.php';

session_start();


if($_POST['removing_product']){
        $newEntry = json_decode(stripslashes($_POST['removing_product']));
        $newEntry = $newEntry + 0;

        // check if session already has shopping cart
        if(isset($_SESSION['shoppingcart'])){
            //check if product already exists in shoppingcart
            for($i = 1;$i < sizeof($_SESSION['shoppingcart']);$i++){
                if($_SESSION['shoppingcart'][$i]->getId() === $newEntry){                                      
                    //also decrease all_products
                    $count_removed = $_SESSION['shoppingcart'][$i]->getCount();
                    $priceAll_removed = $_SESSION['shoppingcart'][$i]->getPriceAll();
                    
                    $_SESSION['shoppingcart'][0]->countDecrease($count_removed);
                    $_SESSION['shoppingcart'][0]->priceDecreaseAll($priceAll_removed);
                    
                    // delete product from product array
                    array_splice($_SESSION['shoppingcart'],$i,1);
                    if(sizeof($_SESSION['shoppingcart']) === 1){
                        unset($_SESSION['shoppingcart']);
                        echo 'unset';
                    }
                        
                }
            }
        }           
    }
