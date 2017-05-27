// This script is a collection of event handling from the main page.

$(document).ready(function() {
    $("#login").click(function(){
//        $(".container").html("");
        $(".container").load("./sites/login.php");
    });
//    hab's in einen link geändert wegen hand, 
//    alternativ eigene id vergeben dann ging die hand auch über css
//    $('.container').on('click','img',function(){
//        $(".container").html("");
//        $(".container").load("./sites/register.php");
//    });
    
    $("#signup").click(function(){
        $(".container").html("");
//        $(".container").load("?page=8");
        window.location.replace("?page=8");
    });
    
    // macht alle elemente der klasse ".draggable" draggable, sobald die Seite fertig geladen ist    
    // in einer sicht selbstaufrufenden funktion:
    $(function() {
        $(".draggable").draggable();
    });
    
    $(".productCage").mouseover(function(){
        $();
    });
    
    // holt eine ProduktId von Image when ein Event abgehandelt wird
    // für spätere Implementierung für Warenkorb
    function getIdFromImg (){
        //$(".productCage).event"
        $(this).children("#product_id").html()
    }
});

