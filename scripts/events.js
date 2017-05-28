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
        $(".draggable").draggable();
    });
    
    $(".productCage").click(function(){
        $("#warenkorb_minion_div").stop();
        $("#warenkorb_minion_div").css({
            bottom:"350px",
            left:"10px"
        });
        
        $("#minion_text").html("");
        
        var id = $(this).find("#product_id").html();
        var desc = $(this).find("#desc_"+id).html();
        $("#minion_text").html(desc);
        
        $("#warenkorb_minion_div").animate({
            bottom: "490px",
            left: "-110px"
        }, 600);
    });
    
    // holt eine ProduktId von Image when ein Event abgehandelt wird
    // für spätere Implementierung für Warenkorb
    function getIdFromImg (){
        //$(".productCage).event"
        $(this).children("#product_id").html()
    }
});

