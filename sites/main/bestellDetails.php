<?php
include 'classes/DB.class.php';
include 'classes/securitas.class.php';
?>



<?php
$db = new DB();
//Bestellung löchen 
if (!empty($_GET['bid']) && !empty($_GET['pid']) && !empty($_GET['produktid'])) {
    $sec = new securitas();
    if ($sec->checkNumeric($_GET['bid'], 0, PHP_INT_MAX) && $sec->checkNumeric($_GET['pid'], 1, PHP_INT_MAX) && $sec->checkNumeric($_GET['produktid'], 1, PHP_INT_MAX)) {
        $bid = $_GET['bid'];
        $pid = $_GET['pid'];
        $produktid = $_GET['produktid'];
        if ($db->deleteBestellung($bid, $pid, $produktid)) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Holly Bananas!</strong>Die Bestellung wurde gelöscht.
            </div>
            <?php
//            echo "<p class='alert alert-success alert-dismissible' role='alert'>Bestellung wurde gelöscht.</p>";
        } else {
            echo "<p class='alert alert-danger alert-dismissible' role='alert'>Bestellung konnte nicht gelöscht werden./p>";
        }
    }
}
?>
<h2 class="page-header">Bestelldetails</h2>
<?php
//Ausgabe
if (!empty($_GET['pid'])) {
    $sec = new securitas();
    if ($sec->checkNumeric($_GET['pid'], 1, PHP_INT_MAX)) {
        $pid = $_GET['pid'];
        if ($db->getOneCust($pid)) {
            $db->getBestellList($pid);
        } else {
            echo "<p class='alert alert-danger alert-dismissible'>DB Problem</p>";
        }
    }
}
?>


<footer>
    <ul class="pager">
        <li class="previous"><a href="?page=5"><span aria-hidden="true">&larr;</span>Zurück</a></li>
    </ul>
</footer>