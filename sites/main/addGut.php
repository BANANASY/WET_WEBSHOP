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
<form class="form-horizontal" action="?page=13" method="post">
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
    </div>
    <div class="form-group">
        <label for="datum" class="col-sm-2 control-label">Ablaufdatum</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" required id="datum" name="datum" placeholder="2017-06-21" >
        </div>
    </div>
    <div class="form-group">
        <label for="preis" class="col-sm-2 control-label">Code</label>
        <div class="col-sm-10">
            <input type="text"  class="form-control" required id="code" name="code" value="<?php echo "g".bin2hex(openssl_random_pseudo_bytes(2)); ?>" readonly="readonly">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button id="submit" type="submit" class="btn btn-default">Speichern</button>
        </div>
    </div>
</form>