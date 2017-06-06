// This script is a collection of event handling from the main page.
var warenkorb_cnt = 0;
var mouseStillDown = false;
var feedbackObj;

$(document).ready(function () {

    initializeDynamicEvents();

    $("#warenkorb_obj").appendTo(".content");

    $("#login").click(function () {
        $(".container").html("");
        window.location.replace("?page=7");
    });

    $("#logout").click(function () {
        $(".container").html("");
        window.location.replace("?page=11");
    });

    $("#signup").click(function () {
        $(".container").html("");
        window.location.replace("?page=8");
    });

    $(".nav_li").mouseover(function () {
        $(this).css("color", "black");
    });

    $(".nav_li").mouseout(function () {
        $(this).css("color", "#777");
    });
    
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
               $(".productContent").html(data);
           });
   });
   
    $("#warenkorb_obj").droppable({
        accept: ".productCage",
        drop: function(event, ui) {
            $("#warenkorb_count").html(++warenkorb_cnt);
            // call dragged object:
            //$(ui.draggable).find(".product_id").html()
            //console.log($(ui.draggable).find(".product_id").html());
            sendDataToSession($(ui.draggable));
        }
    });
    
    $("#warenkorb_obj").draggable({
        containment: $("#content_main")
    });
}); // end of document.ready

$(".content").on("mouseover mouseout", ".productCage", function () {
    initializeDynamicEvents();
});

    //initialisiert alle Events die für dynamisch erstellte Elemente relevant sind.
    function initializeDynamicEvents (){
        // macht alle ausgewählten elemente draggable, sobald die Seite fertig geladen ist    
        // in einer sicht selbstaufrufenden funktion:    
    

        $(".productCage").draggable({ 
            stack: ".productCage",
            revert: true,
            containment: $("#content_main"),           
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
   
        
        //visuelles Feedback für toCart-div bei mousedown:
        $(".toCart").mousedown(function(){
            mouseStillDown = true;
            feedbackObj = this;
            visualFeedback(feedbackObj);
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

// schickt Daten zu einer PHP-File die das Objekt in der Session speichert.
// Gedacht für Warenkorb
function sendDataToSession(loveletter) {

    var id = $(loveletter).find('.product_id').html();

    var jsonString = JSON.stringify(id);

    $.ajax({
        type: "POST",
        url: "../wet_webshop/phpFunctions/productIntoSession.php",
        data: {incoming_product: jsonString},
        success: function () {
            console.log("sending to arrayIntoSession.php");
        }
    }).done(function (data) {
        $(".productContent").append(data);
    });
}

function visualFeedback(obj) {
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
}

$(".check-password").validate({
    submitHandler: function (form) {

        var password = prompt("Gib mal passwort", "");

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

