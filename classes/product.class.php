<?php

class product {
    private $description;
    private $price;
    private $id;
    private $rating = 0;
    
    public function __construct($description, $price, $id){
        $this->description = $description;
        $this->price = $price;
        $this->id = $id;
    }
    
    function getDescription() {
        return $this->description;
    }

    function getPrice() {
        return $this->price;
    }

    function getId() {
        return $this->id;
    }

    function getRating() {
        return $this->rating;
    }
    
    function setDescription($description) {
        $this->description = $description;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRating($rating) {
        $this->rating = $rating;
    }



}
