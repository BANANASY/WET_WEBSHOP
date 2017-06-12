<?php
$produkt = $db->getProduktMeta($produktid);
?>

<h2 id="regform_title">Produkt bearbeiten</h2>
<img src="<?php echo $produkt[1]; ?>" class="col-md-3">
<form class="col-md-9 form-horizontal" id='edit_product' action="?page=4&kat=3" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="kategorie" class="col-sm-2 control-label">Kategorie:</label>
        <div class="col-sm-10">
            <select class="form-control" name="kategorie" required id="kategorie">
                <?php
                switch ($produkt[4]) {
                    case 1:
                        echo "<option selected value='1'>Banana</option>";
                        echo "<option value='2'>Yoghurt</option>";
                        echo "<option value='3'>Eggs</option>";
                        echo "<option value='4'>Rice</option>";
                        echo "<option value='5'>Costumes</option>";
                        break;
                    case 2:
                        echo "<option value='1'>Banana</option>";
                        echo "<option selected value='2'>Yoghurt</option>";
                        echo "<option value='3'>Eggs</option>";
                        echo "<option value='4'>Rice</option>";
                        echo "<option value='5'>Costumes</option>";
                        break;
                    case 3:
                        echo "<option value='1'>Banana</option>";
                        echo "<option value='2'>Yoghurt</option>";
                        echo "<option selected value='3'>Eggs</option>";
                        echo "<option value='4'>Rice</option>";
                        echo "<option value='5'>Costumes</option>";
                        break;
                    case 4:
                        echo "<option value='1'>Banana</option>";
                        echo "<option value='2'>Yoghurt</option>";
                        echo "<option value='3'>Eggs</option>";
                        echo "<option selected value='4'>Rice</option>";
                        echo "<option value='5'>Costumes</option>";
                        break;
                    case 5:
                        echo "<option value='1'>Banana</option>";
                        echo "<option value='2'>Yoghurt</option>";
                        echo "<option value='3'>Eggs</option>";
                        echo "<option value='4'>Rice</option>";
                        echo "<option selected value='5'>Costumes</option>";
                        break;
                }
                ?>

            </select>
        </div>
        <div class="product_error_div col-sm-5" id="kategorie_error"></div>
    </div>
    <div class="form-group">
        <label for="bezeichnung" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" required id="bezeichnung" name="bezeichnung" value="<?php echo $produkt[0]; ?>">
        </div>
        <div class="product_error_div col-sm-5" id="bezeichnung_error"></div>
    </div>
    <div class="form-group">
        <label for="preis" class="col-sm-2 control-label">Preis</label>
        <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" required id="preis" name="preis" value="<?php echo $produkt[2]; ?>">
        </div>
        <div class="product_error_div col-sm-5" id="preis_error"></div>
    </div>
    <div class="form-group">
        <label for="bewertung" class="col-sm-2 control-label">Bewertung</label>
        <div class="col-sm-10">
            <input type="number" max=5 min=0 class="form-control" required id="bewertung" name="bewertung" value="<?php echo $produkt[3]; ?>">
        </div>
        <div class="product_error_div col-sm-5" id="bewertung_error"></div>
    </div>
    <div class="form-group">
        <label for="bild" class="col-sm-2 control-label">Bild</label>
        
        <div class="col-sm-10">
            <input type="file" class="form-control" id="bild" name="bild">
        </div>
        <div class="product_error_div col-sm-5" id="bild_error"></div>
    </div>
    <input type="text" class="hidden" name="oldBild" value="<?php echo $produkt[1]; ?>">
    <input type="text" class="hidden" name="produktid" value="<?php echo $produkt[5]; ?>">

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button id="submit" type="submit" class="btn btn-default">Änderungen übernehmen</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function(){
        // validate product addition
        $("#edit_product").submit(function(){
            
            $(this).find(".product_error_div").removeClass("orderErrorFalse").removeClass("orderErrorTrue");
            
            var category = $(this).find("#kategorie").val();
            var description = $(this).find("#bezeichnung").val();
            var price = $(this).find("#preis").val();
            var rating = $(this).find("#bewertung").val();
            
            console.log(category+", "+description+", "+price+", "+rating);
//            return false;
            
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
            
            if(checkNumeric(price, 1, 5000)){
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