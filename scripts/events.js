// This script is a collection of event handling from the main page.

$(document).ready(function () {
    var mouseStillDown = false;
    var feedbackObj;
    var warenkorb_cnt = 0;
    
    $("#warenkorb_obj").appendTo(".content");
    
    $("#login").click(function () {
//        $(".container").html("");
        $(".container").html("");
//        $(".container").load("?page=8");
        window.location.replace("?page=7");
//        $(".container").load("./sites/login.php");
    });
//    hab's in einen link geändert wegen hand, 
//    alternativ eigene id vergeben dann ging die hand auch über css
//    $('.container').on('click','img',function(){
//        $(".container").html("");
//        $(".container").load("./sites/register.php");
//    });

    $("#signup").click(function () {
        $(".container").html("");
//        $(".container").load("?page=8");
        window.location.replace("?page=8");
    });

    // macht alle ausgewählten elemente draggable, sobald die Seite fertig geladen ist    
    // in einer sicht selbstaufrufenden funktion:
    $(function () {    
        
        $("#warenkorb_obj").draggable({
            containment: $("#content_main"),
        });
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
                $(".productCage").not(this).css("opacity", "1"); 
                $("#warenkorb_obj").css("z-index","1000");
            }        
        });
        $("#warenkorb_obj").droppable({
            accept: ".productCage",
            drop: function(event, ui) {
                $("#warenkorb_count").html(warenkorb_cnt++);
                // call dragged object:
                //$(ui.draggable).find(".product_id").html()
            }
        });
    });
    
    
    // Animation für Warenkorb_obj
    $(".productCage img").click(function(){
        $(".productCage").css("border-color", "black");
        $(this).parent().css("border-color", "#999999");
        
        $("#warenkorb_minion_div").stop();
        $("#warenkorb_hangingSign_div").stop();
        
        $("#warenkorb_hangingSign_div").css({
            bottom:"730px",
            left:"10px"
        });
        
        $("#warenkorb_minion_div").css({
            bottom:"600px",
            left:"10px"
        });
        
        $("#warenkorb_hangingSign_textdiv p").html("");
        $("#minion_text").html("");  
        
        var id = $(this).parent().find(".product_id").html();
        var desc = $(this).parent().find("#desc_"+id).html();
        var price = $(this).parent().find("#price_"+id).html();
        var rating = $(this).parent().find("#rating_"+id).html();
        
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
    
    //visuelles Feedback für toCart-div bei mousedown:
    $(".toCart").mousedown(function(){
        mouseStillDown = true;
        feedbackObj = this;
        visualFeedback(feedbackObj);
    });
    
    $(document).mouseup(function(){
        mouseStillDown = false;
        visualFeedback(feedbackObj);
    });
    
    function visualFeedback (obj){
        if(mouseStillDown){
            $(obj).css({
                "background-color" : "white",
                "color" : "black"
            });
        }else{
            $(obj).css({
                "background-color" : "black",
                "color" : "white"
            });
        }
    }
    
    // schickt Daten zu einer PHP-File die das Objekt in der Session speichert.
    // Gedacht für Warenkorb
    function sendDataToSession(loveletter){
        var array = [];
        var id;
        var description;
        var price;
 
    }
    // holt eine ProduktId von Image when ein Event abgehandelt wird
    // für spätere Implementierung für Warenkorb
    function getIdFromImg (){
        //$(".productCage).event"
        $(this).children("#product_id").html()
    }
});
