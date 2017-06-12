// This script checks the register form clientside before sending it to the
// server

$(document).ready(function () {
    $("#register_form").submit(function(event){
        
        $(this).find(".register_error_div").removeClass("registerErrorFalse").removeClass("registerErrorTrue");
        
        var salutation = $(this).find("#salutation").val();
        var firstName = $(this).find("#firstName").val();
        var lastName = $(this).find("#lastName").val();
        var adress = $(this).find("#adress").val();
        var zip = $(this).find("#zip").val();
        var place = $(this).find("#place").val();
        var email = $(this).find("#email").val();
        var username = $(this).find("#username").val();
        var password1 = $(this).find("#password1").val();
        var password2 = $(this).find("#password2").val();
        var credit = $(this).find("#credit").val();
        
        var testsPassed = true;
        
        //check salutation
        console.log("salutation value: "+salutation);
        if(checkNumeric(salutation, 1, 3)){
            $(this).find("#salutation_error").addClass("registerErrorFalse");
            $(this).find("#salutation_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#salutation_error").addClass("registerErrorTrue");
            $(this).find("#salutation_error").html("Invalid salutation. \n\
                                                    Please sit the fuck down and don't screw with our code");
        }
        
        //check firstName
        if(checkString50(firstName)){
            $(this).find("#firstName_error").addClass("registerErrorFalse");
            $(this).find("#firstName_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#firstName_error").addClass("registerErrorTrue");
            $(this).find("#firstName_error").html("Invalid first name. First name has to be \n\
                                                   below 50 characters and not contain numbers.");
        }
        
        //check lastName
        if(checkString50(lastName)){
            $(this).find("#lastName_error").addClass("registerErrorFalse");
            $(this).find("#lastName_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#lastName_error").addClass("registerErrorTrue");
            $(this).find("#lastName_error").html("Invalid last name. Last name has to be \n\
                                                   below 50 characters.");
        }
        
        /////////////////////////////////////////////////////////////////////
        // DEBUGGING, PLEASE REMOVE                                        //
        /////////////////////////////////////////////////////////////////////
        console.log("--- ADRESS DEBUGGING ---");
        if(isAlphaNumeric(adress)){
            console.log("alphanumeric test passed");
        }else{
            console.log("alphanumeric test not passed");
        }
        if(typeof adress === 'string'){
            console.log("string test passed");
        }else{
            console.log("string test not passed");
        }
        if(adress.length >= 0 && adress.length <= 255){
            console.log("length test passed ("+adress.length+")");
        }else{
            console.log("length test not passed ("+adress.length+")");
        }
        if(containsNumber(adress)){
            console.log("containsNumber test passed");
        }else{
            console.log("containsNumber test not passed");
        }
        /////////////////////////////////////////////////////////////////////
        //check adress
        if(checkString255(adress, true) && containsNumber(adress)){
            $(this).find("#adress_error").addClass("registerErrorFalse");
            $(this).find("#adress_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#adress_error").addClass("registerErrorTrue");
            $(this).find("#adress_error").html("Invalid adress. Adress must be \n\
                                                   max 255 characters.");
        }
        
        //check zip
        if(checkNumeric(zip,1000,10000)){
            $(this).find("#zip_error").addClass("registerErrorFalse");
            $(this).find("#zip_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#zip_error").addClass("registerErrorTrue");
            $(this).find("#zip_error").html("Invalid zip. Zip must be \n\
                                             between 1000 and 10000.");
        }
        
        //check place
        if(checkString255(place, false)){
            $(this).find("#place_error").addClass("registerErrorFalse");
            $(this).find("#place_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#place_error").addClass("registerErrorTrue");
            $(this).find("#place_error").html("Invalid place. Place must be\n\
                                               max 255 characters.");
        }
        
        //check email
        if(checkEmail(email)){
            $(this).find("#email_error").addClass("registerErrorFalse");
            $(this).find("#email_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#email_error").addClass("registerErrorTrue");
            $(this).find("#email_error").html("Invalid email. I don't know what this is, pal.\n\
                                              but it sure ain't an email-adress!");
        }
        
        //check username
        if(checkString16(username)){
            $(this).find("#username_error").addClass("registerErrorFalse");
            $(this).find("#username_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#username_error").addClass("registerErrorTrue");
            $(this).find("#username_error").html("Invalid username. Username must be max\n\
                                                  16 characters and alphanumeric!");
        }
        
        //check password
        if(checkPassword(password1, password2)){
            $(this).find("#password1_error").addClass("registerErrorFalse");
            $(this).find("#password2_error").addClass("registerErrorFalse");
            $(this).find("#password1_error").html("");
            $(this).find("#password2_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#password1_error").addClass("registerErrorTrue");
            $(this).find("#password2_error").addClass("registerErrorTrue");
            $(this).find("#password2_error").html("Invalid password. \n\
                                                   Didn't match criteria. Alphanumeric, min 8, max 16.");
        }
        
        //check credit
        if(checkNumeric(credit,1,3)){
            $(this).find("#credit_error").addClass("registerErrorFalse");
            $(this).find("#credit_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#credit_error").addClass("registerErrorTrue");
            $(this).find("#credit_error").html("Invalid salutation. \n\
                                                Please sit the fuck down and don't screw with our code");
        }
        // if all tests have been passed, the variable 'testsPassed' is still true
        // and we send it to the server, otherwise it has been set to false and
        // prevent it.
        
        if(testsPassed){
            console.log("form okay");
            return true;
        }else{
            console.log("form not okay");
            return false;
        }
    });// end of submit check
});// end of document.ready

function checkNumeric (toCheck, min, max){
    if(typeof toCheck !== 'undefined' && isNumber(toCheck) && toCheck >= min && toCheck <= max){
        return true;
    }else{
        return false;
    }
}

function checkString16 (toCheck){
    if(typeof toCheck === 'string' && isAlphaNumeric(toCheck) && toCheck.length > 0 && toCheck.length <= 16){
        return true;
    }else{
        return false;
    }
}

function checkString50 (toCheck){
    if(typeof toCheck === 'string' && toCheck.length > 0 && toCheck.length <= 50 && !containsNumber(toCheck)){
        return true;
    }else{
        return false;
    }
}

function checkString255 (toCheck, useWhite){
    if(useWhite === true){
        toCheck = toCheck.replace(' ','');
    }
    
    if(typeof toCheck === 'string' && toCheck.length > 0 && toCheck.length <= 255 && isAlphaNumeric(toCheck)){
        return true;
    }else{
        return false;
    }
}

function checkEmail (toCheck){
    var regexEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
    return regexEmail.test(toCheck);
}

function checkPassword (toCheck1, toCheck2){
    if(toCheck1 === toCheck2){
        if(toCheck1.length >= 8 && toCheck1.length <= 16 && toCheck1 && isAlphaNumeric(toCheck1)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

//checks if a string is alphanumeric, allows ö, Ö, ä, Ä, ü, Ü and ß
function isAlphaNumeric(s){
    return /[a-zA-Z\u00c4\u00e4\u00d6\u00f6\u00dc\u00fc\u00df]/.test(s) && /\d/.test(s);
}

//checks if a string has numbers in them
function containsNumber(s){
    var regexContainsNumber = /\d+/g;
    return regexContainsNumber.test(s);
}