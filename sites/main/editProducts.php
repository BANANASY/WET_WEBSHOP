<?php
include 'inc/nav_sec.php';
include 'classes/DB.class.php';
include 'classes/securitas.class.php';

$db = new DB();
$sec = new securitas();

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
} elseif ($_GET['kat'] == 3 && !empty($_GET['ed'])) {
    if ($sec->checkNumeric($_GET['ed'], 0, PHP_INT_MAX)) {
        $produktid = $_GET['ed'];
        $db->editProduct($produktid);
        echo $_GET['ed'];
    }
} else {
    $db->addProduct();
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
