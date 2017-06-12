<?php
include 'DB.class.php';

class product {
    // a product object represents all products of same type (same id) within
    // a list of products    
    
    private $name;
    private $price_all;
    private $price_single;
    private $id;
    private $rating;
    private $count;
    
    // a product of id 0 represents all products within an array of products or
    // a summary of all products in a type of list
    public function __construct($id, $count){
        if($id == -1){
            $this->id=$id;
            $this->count = $count;
            $this->name="all_products";
            $this->price_all=0;
        }else{
            $this->count = $count;
            $this->id = $id;
            $this->setRest();
        }
        
    }
    
    function getName() {
        return $this->name;
    }
    
    function getPriceSingle() {
        return $this->price_single;
    }
    
    function getPriceAll() {
        return $this->price_all;
    }

    function getId() {
        return $this->id;
    }

    function getRating() {
        return $this->rating;
    }
    
    function getCount() {
        return $this->count;
    }
    
    function countIncrease ($amount){
        $this->count = $this->count + $amount;
    }
    
    function countDecrease ($amount) {
        $this->count = $this->count - $amount;
    }
    
    function priceIncrease ($amount) {
        $this->price_all = $this->price_all + ($this->price_single * $amount);
    }
    
    function priceDecrease ($amount) {
        $this->price_all = $this->price_all - ($this->price_single * $amount);
    }
    
    // only works for product objects that represents all products within
    // a list of products
    // increases price_all value
    function priceIncreaseAll ($amount, $price){
        if($this->id === -1){
            $this->price_all = $this->price_all + ($price * $amount);
        }       
    }
    // only works for product objects that represents all products within
    // a list of products
    // decreases price_all value
    function priceDecreaseAll ($price){
        if($this->id === -1){
            $this->price_all = $this->price_all - $price;
        }
    }
    
    //gets meta information for products from database and sets them instance
    //variables. Only called in constructor
    private function setRest() {
        $DB = new DB();
        $product_meta = $DB->getProduktMeta($this->id);
        
        $this->price_single = $product_meta[2];
        $this->price_all = $product_meta[2];
        $this->name = $product_meta[0];
        $this->rating = $product_meta[3];       
    }
    
    // prints the object as a table row
    function printAsTablerow(){
        echo "<tr class='cartTbody'>";
        echo "<td>".$this->getName()."</td>";
        echo "<td class='countTableData'><div class='increaseProductCount countManipulator'><p>+</p></div>".
             "<div class='productCntSingle'>".$this->getCount()."</div>".
             "<div class='decreaseProductCount countManipulator'><p>-</p></div></td>";
        echo "<td class='productPriceSingle'><div class='displayInline'>€ <div class='productPriceSingleValue displayInline'>".$this->getPriceSingle()."</div></div></td>";
        echo "<td class='productPriceAll'><div class='displayInline'>€ <div class='productPriceAllValue displayInline'>".$this->getPriceAll()."</div></div></td>";
        echo "<td class='cartTdCenter cartDeleteProduct'><button class='btn btn-default cartDeleteProduct'>Löschen</button></td>";
        echo "<td class='product_id'>".$this->getId()."</td>";
        echo "</tr>";
    }
}
