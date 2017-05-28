// This script is a collection of event handling from the main page.

$(document).ready(function () {
    $("#login").click(function () {
        $(".container").html("");
        window.location.replace("?page=7");
    });


    $("#signup").click(function () {
        $(".container").html("");
        window.location.replace("?page=8");
    });

    // macht alle elemente der klasse ".draggable" draggable, sobald die Seite fertig geladen ist    
    // in einer sicht selbstaufrufenden funktion:
    $(function () {
        $(".draggable").draggable();
    });
    
    $(".productCage").click(function(){
        $(".productCage img").css("border-color", "black");
        $(this).find(".product_img").css("border-color", "#999999");
        
        $("#warenkorb_minion_div").stop();
        $("#warenkorb_hangingSign_div").stop();
        
        $("#warenkorb_hangingSign_div").css({
            bottom:"470px",
            left:"10px"
        });
        
        $("#warenkorb_minion_div").css({
            bottom:"350px",
            left:"10px"
        });
        
        $("#warenkorb_hangingSign_textdiv p").html("");
        $("#minion_text").html("");     
        
        var id = $(this).find("#product_id").html();
        var desc = $(this).find("#desc_"+id).html();
        var price = $(this).find("#price_"+id).html();
        var rating = $(this).find("#rating_"+id).html();
        
        $("#minion_text").html(desc);
        $("#warenkorb_hangingSign_price").html(price);
        $("#warenkorb_hangingSign_rating").html(rating);
        
        $("#warenkorb_minion_div").animate({
            bottom: "490px",
            left: "-110px"
        }, 600);
        
        $("#warenkorb_hangingSign_div").animate({
            bottom: "360px",
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
