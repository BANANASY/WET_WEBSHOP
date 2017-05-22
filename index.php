<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>BaYo</title>
        <!-- get JQuery -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- get Bootstrap -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="./res/stylesheet.css">
    </head>    
    <body>
        <?php
        include 'inc/nav_main.php';
        ?>
        <div class="div_logo"><h1>The Banana and Yoghurt Shop</h1></div>               

        <div class="container">
            <?php
            include 'phpFunctions/loadMain.php';
            if (isset($_GET["page"])) {
                $page = $_GET['page'];
                loadMain($page);
            } else {
                $page = 0;
                loadMain($page);
            }
            
            
            
            ?>
        </div>
        
        <script type="text/javascript" src="./scripts/events.js"></script>
    </div> <!-- container -->
</body>
</html>
