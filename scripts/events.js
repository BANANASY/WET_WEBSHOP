// This script is a collection of event handling from the main page.

$(document).ready(function () {
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

    // macht alle elemente der klasse ".draggable" draggable, sobald die Seite fertig geladen ist    
    // in einer sicht selbstaufrufenden funktion:
    $(function () {
        $("#warenkorb_obj").draggable({
            containment: $("#content_main")
        });
        $(".content .product_img").draggable({ 
            stack: ".content .product_img",
            appendTo: ".content",
            revert: "invalid",
            refreshPositions: true,
            containment: $("#content_main")           
//            start: function() { $(".product_img").not(this).css("opacity", "0.5"); },
//            stop: function() { $(".product_img").not(this).css("opacity", "1"); }        
        });
    });
    
    $(".productCage img").click(function(){
        $(".productCage img").css("border-color", "black");
        $(this).css("border-color", "#999999");
        
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
    
    // holt eine ProduktId von Image when ein Event abgehandelt wird
    // für spätere Implementierung für Warenkorb
    function getIdFromImg (){
        //$(".productCage).event"
        $(this).children("#product_id").html()
    }
});
