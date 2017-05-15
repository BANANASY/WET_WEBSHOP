// This script is a collection of event handling from the main page.

$(document).ready(function() {
    $("#login").click(function(){
        $(".container").html("");
        $(".container").load("./sites/login.php");
    });
    
    $('.container').on('click','img',function(){
        $(".container").html("");
        $(".container").load("./sites/register.php");
    });
    
    $("#signup").click(function(){
        $(".container").html("");
        $(".container").load("./sites/register.php");
    });
    
});

