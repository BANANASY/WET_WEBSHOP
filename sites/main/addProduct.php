<?php
include 'inc/nav_sec_adminP.php';
//include 'classes/DB.class.php';
include 'classes/securitas.class.php';

if (!empty($_POST)) {
    $sec = new securitas();
    $produkt = $sec->checkNewProd(0);

    if ($produkt !== null) {
        $db = new DB();
        if ($db->addProduct($produkt['name'], $produkt['path'], $produkt['preis'], $produkt['bewertung'], $produkt['kid'])) {
            echo "<p class='bg-success'>Produkt wurde hinzugefügt.</p>";
        } else {
            echo "<p class='bg-danger'>SQL Error.</p>";
        }
    } else {
        echo "<p class='bg-danger'>POST error.</p>";
    }
}
?>
<h2 id="regform_title" class="page-header">Neues Produkt</h2>
<form class="form-horizontal" id='add_product' action="?page=12" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="kategorie" class="col-sm-2 control-label">Kategorie:</label>
        <div class="col-sm-10">
            <select class="form-control" name="kategorie" required id="kategorie">
                <option value="">Wähle eine Kategorie ...</option>
                <option value="1">Banana</option>
                <option value="2">Yoghurt</option>
                <option value="3">Eggs</option>
                <option value="4">Rice</option>
                <option value="5">Costumes</option>
            </select>
        </div>
        <div class="product_error_div col-sm-5" id="kategorie_error"></div>
    </div>
    <div class="form-group">
        <label for="bezeichnung" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" required id="bezeichnung" name="bezeichnung">
        </div>
        <div class="product_error_div col-sm-5" id="bezeichnung_error"></div>
    </div>
    <div class="form-group">
        <label for="preis" class="col-sm-2 control-label">Preis</label>
        <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" required id="preis" name="preis">
        </div>
        <div class="product_error_div col-sm-5" id="preis_error"></div>
    </div>
    <div class="form-group">
        <label for="bewertung" class="col-sm-2 control-label">Bewertung</label>
        <div class="col-sm-10">
            <input type="number" max=5 min=0 class="form-control" required id="bewertung" name="bewertung">
        </div>
        <div class="product_error_div col-sm-5" id="bewertung_error"></div>
    </div>
    <div class="form-group">
        <label for="bild" class="col-sm-2 control-label">Bild</label>
        <div class="col-sm-10">
            <input type="file" accept="image" class="form-control" required id="bild" name="bild">
        </div>
        <div class="product_error_div col-sm-5" id="image_error"></div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button id="submit" type="submit" class="btn btn-default">Speichern</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        // validate product addition
        $("#add_product").submit(function(){
            $(this).find(".product_error_div").removeClass("orderErrorFalse").removeClass("orderErrorTrue");
            
            var category = $(this).find("#kategorie").val();
            var description = $(this).find("#bezeichnung").val();
            var price = $(this).find("#preis").val();
            var rating = $(this).find("#bewertung").val();
            
            var testsPassed = true;
            
            if(checkNumeric(category, 1, 5)){
                $(this).find("#kategorie_error").addClass("orderErrorFalse gimmeWidth");
                $(this).find("#kategorie_error").html("");
            }else{
                testsPassed = false;
                $(this).find("#kategorie_error").addClass("orderErrorTrue gimmeWidth");
                $(this).find("#kategorie_error").html("Invalid category. \n\
                                                        Please sit the fuck down and don't screw with our code");
            }
            
            if(checkString50(description)){
                $(this).find("#bezeichnung_error").addClass("orderErrorFalse gimmeWidth");
                $(this).find("#bezeichnung_error").html("");
            }else{
                testsPassed = false;
                $(this).find("#bezeichnung_error").addClass("orderErrorTrue gimmeWidth");
                $(this).find("#bezeichnung_error").html("Invalid description. First name has to be \n\
                                                       below 50 characters and not contain numbers.");
            }
            
            if(checkNumeric(price, 0.01, 5000)){
                $(this).find("#preis_error").addClass("orderErrorFalse gimmeWidth");
                $(this).find("#preis_error").html("");
            }else{
                testsPassed = false;
                $(this).find("#preis_error").addClass("orderErrorTrue gimmeWidth");
                $(this).find("#preis_error").html("Invalid price. \n\
                                                        Valid price range is 0.01 to 5000");
            }
            
            if(checkNumeric(rating, 1, 5000)){
                $(this).find("#bewertung_error").addClass("orderErrorFalse gimmeWidth");
                $(this).find("#bewertung_error").html("");
            }else{
                testsPassed = false;
                $(this).find("#bewertung_error").addClass("orderErrorTrue gimmeWidth");
                $(this).find("#bewertung_error").html("Invalid rating. \n\
                                                        Valid rating range is 1 to 5");
            }
            
            if(testsPassed){
                return true;
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

        function checkString50 (toCheck){
            if(typeof toCheck === 'string' && toCheck.length > 0 && toCheck.length <= 50 && !containsNumber(toCheck)){
                return true;
            }else{
                return false;
            }
        }

        function isNumber(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }

        //checks if a string has numbers in them
        function containsNumber(s){
            var regexContainsNumber = /\d+/g;
            return regexContainsNumber.test(s);
        }
    });//end of document.ready
</script>