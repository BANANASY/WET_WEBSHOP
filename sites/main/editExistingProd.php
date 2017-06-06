<?php
$produkt = $db->getProduktMeta($produktid);
?>

<h2 id="regform_title">Produkt bearbeiten</h2>
<img src="<?php echo $produkt[1]; ?>" class="col-md-3">
<form class="col-md-9 form-horizontal" action="?page=4&kat=3" method="post" enctype="multipart/form-data">
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
    </div>
    <div class="form-group">
        <label for="bezeichnung" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" required id="bezeichnung" name="bezeichnung" value="<?php echo $produkt[0]; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="preis" class="col-sm-2 control-label">Preis</label>
        <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" required id="preis" name="preis" value="<?php echo $produkt[2]; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="bewertung" class="col-sm-2 control-label">Bewertung</label>
        <div class="col-sm-10">
            <input type="number" max=5 min=0 class="form-control" required id="bewertung" name="bewertung" value="<?php echo $produkt[3]; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="bild" class="col-sm-2 control-label">Bild</label>
        
        <div class="col-sm-10">
            <input type="file" class="form-control" id="bild" name="bild">
        </div>
    </div>
    <input type="text" class="hidden" name="oldBild" value="<?php echo $produkt[1]; ?>">
    <input type="text" class="hidden" name="produktid" value="<?php echo $produkt[5]; ?>">

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button id="submit" type="submit" class="btn btn-default">Änderungen übernehmen</button>
        </div>
    </div>
</form>