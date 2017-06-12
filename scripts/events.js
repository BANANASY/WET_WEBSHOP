// This script is a collection of event handling from the main page.
var warenkorb_cnt = 0;
var mouseStillDown = false;
var feedbackObj_product;
var feedbackObj_cart;
var eventsBinded = false;
var dragCheck = false;

$(document).ready(function () {
    if(!eventsBinded){
        initializeDynamicEvents();
        eventsBinded = true;
    }    
    
    // append to content for correct ordering
    $("#warenkorb_obj").appendTo(".content");
    
    // load login page when clicked on login div
    $("#login").click(function () {
        $(".container").html("");
        window.location.replace("?page=7");
    });

    // prompt user to home when clicking on logout div
    $("#logout").click(function () {
        $(".container").html("");
        window.location.replace("?page=11");
    });
    
    // load register form when clicking on signup div
    $("#signup").click(function () {
        $(".container").html("");
        window.location.replace("?page=8");
    });
    
    // visual feedback on all list items in both navbars when user moves mouse
    // over
    $(".nav_li").mouseover(function () {
        $(this).css("color", "black");
    });
    
    // visual feedback on all list items in both navbars when user moves mouse
    // out
    $(".nav_li").mouseout(function () {
        $(this).css("color", "#777");
    });
    
    // load products for each category respectively in nav_sec
    $(".nav_li").click(function(){
       $(".productContent").html("Loading...");
       
       var id = $(this).data("value");
       
       $.ajax({
           url:'../wet_webshop/phpFunctions/sendProductsByCat.php',
           type: "POST",
           data: {kat:id},
           async: false,
           dataType: "html"
           }).done(function(data){
               eventsBinded = false;
               $(".productContent").html(data);
           });
   });
   
   // give orb the ability to accept draggable products and trigger a drop
   // event that sends dropped object to shopping cart in session
    $("#warenkorb_obj").droppable({
        accept: ".productCage",
        drop: function(event, ui) {      
            sendDataToSession($(ui.draggable));            
        }
    });
    
    // make orb draggable and contain in '#container_content' div
    $("#warenkorb_obj").draggable({
        containment: $("#container_content"),
        drag: function(){
            dragCheck = true;
        },
        stop: function(){
            dragCheck = false;
        }
    });
    
    // if not dragged, click on orb will send user to shopping cart page
    $("#warenkorb_obj").click(function(){
        if (!dragCheck) {
            $(".container").html("");
            window.location.replace("?page=3");
        }
    });
    
    // from here until end of document.ready there are only 
    // events for shopping cart page 
    
    // visual feedback for .countManipulator divs    
    $(".countManipulator").mousedown(function(){
        mouseStillDown = true;
        feedbackObj_cart = this;
        visualFeedback(feedbackObj_cart, 1);
    });
    
    // as above
    $("#cartTable").mouseup(function(){
        mouseStillDown = false;
        visualFeedback(feedbackObj_cart, 1);
    });
    
    // when delete button is clicked, adjust values on client side accordingly
    // then call a function that deletes product and all its values out of
    // shopping cart in session
    $(".cartDeleteProduct").click(function(){
        $(this).parent().parent().remove();
        
        var current_row = $(this).parent().parent();
        var current_cnt = parseInt(current_row.find(".productCntSingle").html());
        var current_priceAll = parseFloat(current_row.find(".productPriceAllValue").html());
        
        var table = $("#cartTable");
        var allProducts_priceObj = table.find("#allProductsPrice");
        var allProducts_price = parseFloat(allProducts_priceObj.html());
        var allProducts_cntObj = table.find("#allProductsCount");
        var allProducts_cnt = parseInt(allProducts_cntObj.html());
        
        allProducts_price = allProducts_price - current_priceAll;
        allProducts_price = allProducts_price.toFixed(2);
        allProducts_cnt = allProducts_cnt - current_cnt;
        
        if(allProducts_price <= 0){
            $(".cartContent").html("Keine Produkte im Warenkorb vorhanden.");
        }
        
        allProducts_priceObj.html(allProducts_price);
        allProducts_cntObj.html(allProducts_cnt);
        
        removeProductFromSession($(this).parent().parent());
    });
    
    // when decrease button is clicked, adjust values on client side accordingly
    // then call a function that decreases product amount by one and only one
    // from shopping cart in session 
    $(".decreaseProductCount").click(function(){
        var current_cntObj = $(this).parent().find(".productCntSingle");
        var current_cnt = parseInt(current_cntObj.html());
        var current_row= $(this).parent().parent();
        var price_single = current_row.find(".productPriceSingleValue").html();
        price_single = parseFloat(price_single);
        var price_all = current_row.find(".productPriceAllValue").html();
        price_all = parseFloat(price_all);
        var price_allObj = current_row.find(".productPriceAllValue");
        var table = current_row.parent().parent();
        var allProducts_priceObj = table.find("#allProductsPrice");
        var allProducts_price = parseFloat(allProducts_priceObj.html());
        var allProducts_cntObj = table.find("#allProductsCount");
        var allProducts_cnt = parseInt(allProducts_cntObj.html());
        
        allProducts_price = allProducts_price - price_single;
        allProducts_price = allProducts_price.toFixed(2);
        price_all = price_all - price_single;
        price_all = price_all.toFixed(2);
        price_allObj.html(price_all);
        
        if(price_all <= 0){
            current_row.remove();
        }
        
        if(allProducts_price <= 0 || allProducts_cnt <= 0){
            $(".cartContent").html("Keine Produkte im Warenkorb vorhanden.");
        }
        
        allProducts_priceObj.html(allProducts_price);
        allProducts_cntObj.html(allProducts_cnt-1);
        current_cntObj.html(current_cnt - 1);
        
        decreaseProductFromSession(current_row);
    });
    
    // when increase button is clicked, adjust values on client side accordingly
    // then call a function that increases product amount by one and only one
    // from shopping cart in session
    $(".increaseProductCount").click(function(){
        var current_cntObj = $(this).parent().find(".productCntSingle");
        var current_cnt = parseInt(current_cntObj.html());
        var current_row= $(this).parent().parent();
        var price_single = current_row.find(".productPriceSingleValue").html();
        price_single = parseFloat(price_single);
        var price_all = current_row.find(".productPriceAllValue").html();
        price_all = parseFloat(price_all);
        var price_allObj = current_row.find(".productPriceAllValue");
        var table = current_row.parent().parent();
        var allProducts_priceObj = table.find("#allProductsPrice");
        var allProducts_price = parseFloat(allProducts_priceObj.html());
        var allProducts_cntObj = table.find("#allProductsCount");
        var allProducts_cnt = parseInt(allProducts_cntObj.html());
        
        allProducts_price = allProducts_price + price_single;
        allProducts_price = allProducts_price.toFixed(2);
        price_all = price_all + price_single;
        price_all = price_all.toFixed(2);
        price_allObj.html(price_all);

        allProducts_priceObj.html(allProducts_price);
        allProducts_cntObj.html(allProducts_cnt+1);
        current_cntObj.html(current_cnt + 1);
        sendDataToSession(current_row);
    });
    
}); // end of document.ready

//makes sure all dynamically loaded elements have necessary events bound to them
//at all times and only does so once per dynamical load.
$("#nav_sec").on("mouseout", function () {
    if(!eventsBinded){
        initializeDynamicEvents();
        console.log("dynamic events added");
        eventsBinded = true;
    }   
});

    //initializes all events for dynamically loaded elements
    function initializeDynamicEvents (){
        //load current amount of products in shopping cart into orb
        getCartCounter();
        
        //implement search function for products
        $("#search-input").on("keyup", function(){
            var g = $(this).val().toLowerCase();
            $(".productCage").find(".product_description").each(function(){
                 var s = $(this).html().toLowerCase();
                 if (s.indexOf(g)!== -1) {
                     $(this).parent().parent().parent().parent().show();
                 }else {
                     $(this).parent().parent().parent().parent().hide();
                 }
            });
        });
        
        //makes all product cages draggable, gives visual feedback, and handles
        //order (z-index)
        $(".productCage").draggable({ 
            stack: ".productCage",
            revert: true,
            // not sure if this would be useful
//            containment: $("#container_content"),           
            start: function() { 
                $("#nav_sec").css("z-index",-1);
                $("#warenkorb_obj").css("z-index","0");
                $(".productCage").not(this).css("opacity", "0.5");
            },
            stop: function() { 
                $("#nav_sec").css("z-index",1);
                $(".productCage").not(this).css("opacity", "1"); 
                $("#warenkorb_obj").css("z-index","1000");
            }        
        });
        
        //sends one product to session
        $(".toCart").click(function(){
            sendDataToSession($(this).parent());           
   
        });
        
        //visual feedback for toCart-divs on mousedown
        $(".toCart").mousedown(function(){
            mouseStillDown = true;
            feedbackObj_product = this;
            visualFeedback(feedbackObj_product,0);
        });
        
        //visual feedback for toCart-divs on mouseup
        $(".productCage").mouseup(function () {
            mouseStillDown = false;
            visualFeedback(feedbackObj_product,0);
        });
        
        // this event handles the animation of the shopping cart orb, if a user
        // clicks on a product div information about clicked product is displayed
        // via the animation
        $(".productCage img").click(function () {
            $(".productCage").css("border-color", "black");
            $(this).parent().css("border-color", "#999999");

            $("#warenkorb_minion_div").stop();
            $("#warenkorb_hangingSign_div").stop();

            $("#warenkorb_hangingSign_div").css({
                bottom: "730px",
                left: "10px"
            });

            $("#warenkorb_minion_div").css({
                bottom: "600px",
                left: "10px"
            });

            $("#warenkorb_hangingSign_textdiv p").html("");
            $("#minion_text").html("");

            var id = $(this).parent().find(".product_id").html();
            var desc = $(this).parent().find("#desc_" + id).html();
            var price = $(this).parent().find("#price_" + id).html();
            var rating = $(this).parent().find("#rating_" + id).html();

            $("#minion_text").html(desc);
            $("#warenkorb_hangingSign_price").html(price);
            $("#warenkorb_hangingSign_rating").html(rating);

            $("#warenkorb_minion_div").animate({
                bottom: "715px",
                left: "-145px"
            }, 600);

            $("#warenkorb_hangingSign_div").animate({
                bottom: "605px",
                left: "10px"
            }, 600);    
        });
   
} // end of initializeDynamicEvents()

// sends data to productIntoSession.php which adds entirely new product.class.php
// objects into the session or increases their counter if they are already 
// existant
function sendDataToSession(loveletter) {

    var id = $(loveletter).find('.product_id').html();

    var jsonString = JSON.stringify(id);

    $.ajax({
        type: "POST",
        url: "../wet_webshop/phpFunctions/productIntoSession.php",
        data: {incoming_product: jsonString}
    }).done(function(){
        getCartCounter();
    });
}

// decreases a products count by exactly 1
function decreaseProductFromSession(toDecrease){
    var id = $(toDecrease).find(".product_id").html();
    var jsonString = JSON.stringify(id);
    
    $.ajax({
        type: "POST",
        url: "../wet_webshop/phpFunctions/decreaseProductsInSession.php",
        data: {decreasing_product: jsonString},
        success: function () {
            console.log("sending to decreaseProductsFromSession.php ... ID sent: "+id);
        }
    });
}

// removes all products from one specific ID from session
function removeProductFromSession (toRemove) {
    var id = $(toRemove).find('.product_id').html();
    var jsonString = JSON.stringify(id);
    
    $.ajax({
        type: "POST",
        url: "../wet_webshop/phpFunctions/deleteProductFromSession.php",
        data: {removing_product: jsonString},
        success: function () {
            console.log("sending to arrayIntoSession.php");
        }
    });
}

// get count of all products currently in shopping cart
function getCartCounter() {
    $.ajax({
        type: "POST",
        url: "../wet_webshop/phpFunctions/getShoppingCartCount.php"
    }).done(function (data) {       
        warenkorb_cnt = parseInt(data);
        if(isNaN(warenkorb_cnt)){
            $("#warenkorb_count").html("0");
        }else{
            if(warenkorb_cnt >= 10){
                $("#warenkorb_count").css("left","110px");
                $("#warenkorb_count").html(warenkorb_cnt);
            }else{
                $("#warenkorb_count").css("left","140px");
                $("#warenkorb_count").html(warenkorb_cnt);
            }
            
        }       
    });
}

// handles visual feedback for .toCart-divs and .countManipulator-divs
function visualFeedback(obj, number) {
    
    // 0 = visual feedback for produkte.php
    if(number === 0){
        if (mouseStillDown) {
            $(obj).css({
                "background-color": "white",
                "color": "black"
        });
        } else {
            $(obj).css({
                "background-color": "black",
                "color": "white"
            });
        }
    }else if(number === 1){
        if (mouseStillDown) {
            $(obj).css({
                "background-color": "black",
                "color": "white"
            });
        } else {
            $(obj).css({
                "background-color": "#f0efec",
                "color": "black"
            });
        }
    }
    
    
    // 1 = visual feedback for warenkorb.php
}

//validates passwords
$(".check-password").validate({
    submitHandler: function (form) {

        var password = alert("<input type='password'><button>nice</button>");

        var jsonString = JSON.stringify(password);

        $.ajax({
            type: "POST",
            url: "phpFunctions/checkPassword.php",
            data: {incoming_userAut: jsonString},
            success: function () {
                console.log(jsonString);
            }
        }).done(function (data) {
            $("#ajax").append(data);
        });

    }
});

