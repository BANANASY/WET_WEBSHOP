<?php
include 'inc/nav_sec.php';
include 'classes/DB.class.php';

$DB = new DB();

if (empty($_GET['kat']) || $_GET['kat'] == 1) {
    $DB->getProductList();
} else {
    $DB->addProduct();
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
