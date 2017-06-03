<?php
    include_once ('../classes/DB.class.php');

    if(isset($_POST['kat'])){
        $category = $_POST['kat'];
        
        $DB = new DB();
        $DB->getProductsByCategory($category);
    }

