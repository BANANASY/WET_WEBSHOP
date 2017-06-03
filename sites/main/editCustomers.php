<?php

include 'classes/DB.class.php';

echo "<h2>Kunden Bearbeiten</h2>";

$db = new DB();
$db->getCustList();

?>

<p>2) Kunden verwalten</p>
<ol>
<li>Der Admin hat die Möglichkeit, alle existierenden Kunden
    aufzulisten und deren Bestelldetails einzusehen. Jeder Kunde kann
    vom Admin deaktiviert werden, somit ist kein Login mehr bzw.
    keine Einkäufe mit diesem Account möglich.</li>
<li>Einzelne Produkte können aus der Bestellung des Kunden entfernt
    werden und sind auch für den Kunden nicht mehr sichtbar.</li>
</ol>