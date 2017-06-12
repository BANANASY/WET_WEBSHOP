<?php
include 'inc/nav_sec_adminG.php';
//include 'classes/DB.class.php';
include 'classes/securitas.class.php';

if (!empty($_POST)) {
    $sec = new securitas();
    $gutschein = $sec->checkNewGut();
    if ($gutschein !== null) {
        $db = new DB();
        if ($db->addGutschein($gutschein['wert'], $gutschein['datum'], $gutschein['code'])) {
            echo "<p class='bg-success'>Gutschein wurde hinzugefügt.</p>";
        } else {
            echo "<p class='bg-danger'>SQL Error.</p>";
        }
    } else {
        echo "<p class='bg-danger'>Das Datum muss im Format yyyy-mm-dd übergeben werden.</p>";
    }
}
?>

<h2 id="regform_title" class='page-header'>Neuer Gutschein</h2>
<div class='coupon_formDiv'>
<form class="form-horizontal" id='coupon_form' action="?page=13" method="post">
    <div class="form-group">
        <label for="wert" class="col-sm-2 control-label">Wert</label>
        <div class="col-sm-10">
            <select class="form-control" name="wert" required id="wert">
                <option value="">Wähle einen Wert ...</option>
                <option value="20">€ 20</option>
                <option value="50">€ 50</option>
                <option value="100">€ 100</option>
                <option value="500">€ 500</option>
            </select>
        </div>
        <div class="coupon_error_div col-sm-5" id="wert_error"></div>
    </div>
    <div class="form-group">
        <label for="datum" class="col-sm-2 control-label">Ablaufdatum</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" required id="datum" name="datum" placeholder="2017-06-21" >
        </div>
        <div class="coupon_error_div col-sm-5" id="datum_error"></div>
    </div>
    <div class="form-group">
        <label for="preis" class="col-sm-2 control-label">Code</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" required id="code" name="code" value="<?php echo substr(bin2hex(openssl_random_pseudo_bytes(3)), 0, 5); ?>" readonly="readonly">
        </div>
        <div class="coupon_error_div col-sm-5" id="code_error"></div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button id="submit" type="submit" class="btn btn-default">Speichern</button>
        </div>
    </div>
</form>
</div>

<script>
    //check form input on client side
    $("#coupon_form").submit(function(){
        $(this).find(".coupon_error_div").removeClass("registerErrorFalse").removeClass("registerErrorTrue");
        
        var code = $(this).find("#code").val();
        var date_expireStr = $(this).find("#datum").val();
        var date_expire = new Date(date_expireStr);
        var value = $(this).find("#wert").val();
        var currentDate = new Date();
        var testsPassed = true;
        
        if(checkString5(code)){
            $(this).find("#code_error").addClass("orderErrorFalse");
            $(this).find("#code_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#code_error").addClass("orderErrorTrue");
            $(this).find("#code_error").html("Invalid code. Seems like our\n\
                                             generator fucked up. \n\
                                            Please reload the page.");
        }
        
        if(checkDate(date_expire)){
            $(this).find("#datum_error").addClass("orderErrorFalse");
            $(this).find("#datum_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#datum_error").addClass("orderErrorTrue");
            $(this).find("#datum_error").html("Invalid date. Date must be\n\
                                            in the future.");
        }
        
        if(checkNumeric(value,20,500)){
            $(this).find("#wert_error").addClass("orderErrorFalse");
            $(this).find("#wert_error").html("");
        }else{
            testsPassed = false;
            $(this).find("#wert_error").addClass("orderErrorTrue");
            $(this).find("#wert_error").html("Invalid value. Don't cheat the\n\
                                                system, maaaan!");
        }
        
        if(testsPassed){
            return false;
        }else{
            return false;
        }
    });
    
    function checkNumeric (toCheck, min, max){
        if(typeof toCheck !== 'undefined' && isNumber(toCheck) && toCheck >= min && toCheck <= max){
            return true;
        }else{
            return false;
        }
    }
    
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    
    function checkDate (toCheck){
        var currentDate = new Date();
        
        if(currentDate > toCheck){
            return false;
        }else{
            return true;
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
</script>