<?php
include 'inc/nav_sec.php';
include 'classes/DB.class.php';

$db = new DB();
echo "<h2>Produkte bearbeiten</h2>";
$db->getGutscheinList();
?>




<h2>Gutscheine Bearbeiten</h2>
<p>3) Gutscheine verwalten</p>
<ol>
    <li>Weiters gibt es für den Admin die Option, Gutscheincodes zu
        erstellen. Jeder Gutscheincode wird zufällig generiert und besteht
        aus einem 5-stelligen alphanumerischen Code. Je Gutschein werden
        Wert sowie ein Gültigkeitsdatum angelegt.</li>
    <li>Der Admin hat eine Übersicht über alle Gutscheincodes, deren
        Datum sowie Wert. Bereits eingelöste bzw. abgelaufene Gutscheine
        werden ebenfalls gelistet, jedoch entsprechend markiert.</li>
</ol>