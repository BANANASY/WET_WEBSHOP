<?php
include 'inc/nav_sec.php';
include 'classes/DB.class.php';
include 'classes/securitas.class.php';

$db = new DB();
$sec = new securitas();

//if delete go here
if (!empty($_GET['del'])) {
    $produktid = $_GET['del'];
    if ($sec->checkNumeric($produktid, 0, PHP_INT_MAX)) {
        $pfad = $db->getImagePathById($produktid);
        if (!empty($pfad)) {
            unlink($pfad);
        }
        if ($db->deleteProductById($produktid)) {
            echo "<p class='bg-success'>Produkt wurde gelöscht.</p>";
        }
    } else {
        echo "<p class='bg-danger'>Produkt wurde nicht gelöscht.</p>";
    }
}

if (empty($_GET['kat']) || $_GET['kat'] == 1) {
    $db->getProductList();
} elseif ($_GET['kat'] == 3 && !empty($_GET['ed'])) { //if edit go here
    if ($sec->checkNumeric($_GET['ed'], 0, PHP_INT_MAX)) {
        $produktid = $_GET['ed'];
        include "sites/main/editExistingProd.php";
    }
} elseif (!empty($_GET['kat']) || $_GET['kat'] == 3) {//go here to update
    var_dump($_POST);
    var_dump($_FILES);
//        if($db->editProduct($produktid)){
//            
//            echo "<p class='bg-success'>Produkt wurde erfolgreich geändert.</p>";
//        }
} else {
    echo "<p class='bg-danger'>Holy Bananos, don't mess around with the URL!</p>";
}
?>

<h2>Produkte Bearbeiten</h2>
<ol>
    <li>Im Bereich „Produkte bearbeiten“ kann der Administrator sowohl
        neue Produkte anlegen (zumindest mit Name, Beschreibung,
        Bewertung, Preis, Foto) als auch Produkte bearbeiten und löschen.
    </li>
    <li>Für jedes Produkt kann ein Produktfoto hochgeladen werden.</li>
</ol>
