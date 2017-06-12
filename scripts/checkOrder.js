
$(document).ready(function(){
    $('#zahlungsart_form').submit(function(){
        var testPassed = true;
        var zahlungsart = $(this).find('#zahlungsart').val();
        
        if(checkNumeric(zahlungsart, 1, 3)){
            $(this).find("#zahlungsart_error").addClass("orderErrorFalse");
            $(this).find("#zahlungsart_error").html("");
        }else{
            testPassed = false;
            $(this).find("#zahlungsart_error").addClass("orderErrorTrue");
            $(this).find("#zahlungsart_error").html("Invalid payment method. \n\
                                                    Please sit the fuck down and don't screw with our code");
        }
        
        if(testPassed){
            return true;
        }else{
            return false;
        }
        
    });
    
    $('#gutschein_form').submit(function(){
        var testPassed = true;
        var gutschein = $(this).find('#gutschein').val();
        
        if(checkString5(gutschein)){
            $(this).find("#gutschein_error").addClass("orderErrorFalse");
            $(this).find("#gutschein_error").html("");
        }else{
            testPassed = false;
            $(this).find("#gutschein_error").addClass("orderErrorTrue");
            $(this).find("#gutschein_error").html("Invalid coupon. Coupon has to be \n\
                                                   exactly 5 characters and contain numbers.");
        }
        
        if(testPassed){
            return true;
        }else{
            return false;
        }
        
    });
});

function checkNumeric (toCheck, min, max){
    if(typeof toCheck !== 'undefined' && isNumber(toCheck) && toCheck >= min && toCheck <= max){
        return true;
    }else{
        return false;
    }
}

function checkString5 (toCheck){
    if(typeof toCheck === 'string' && isAlphaNumeric(toCheck) && toCheck.length === 5){
        return true;
    }else{
        return false;
    }
}

function isAlphaNumeric(s){
    return /[a-zA-Z\u00c4\u00e4\u00d6\u00f6\u00dc\u00fc\u00df]/.test(s) && /\d/.test(s);
}