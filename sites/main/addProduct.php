<?php
include 'inc/nav_sec.php';
include 'classes/DB.class.php';
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
<h2 id="regform_title">Neues Produkt</h2>
<form class="form-horizontal" action="?page=12" method="post" enctype="multipart/form-data">
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
    </div>
    <div class="form-group">
        <label for="bezeichnung" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" required id="bezeichnung" name="bezeichnung">
        </div>
    </div>
    <div class="form-group">
        <label for="preis" class="col-sm-2 control-label">Preis</label>
        <div class="col-sm-10">
            <input type="number" step="0.01" class="form-control" required id="preis" name="preis">
        </div>
    </div>
    <div class="form-group">
        <label for="bewertung" class="col-sm-2 control-label">Bewertung</label>
        <div class="col-sm-10">
            <input type="number" max=5 min=0 class="form-control" required id="bewertung" name="bewertung">
        </div>
    </div>
    <div class="form-group">
        <label for="bild" class="col-sm-2 control-label">Bild</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" required id="bild" name="bild">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button id="submit" type="submit" class="btn btn-default">Speichern</button>
        </div>
    </div>
</form>