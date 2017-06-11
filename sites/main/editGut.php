<?php
include 'inc/nav_sec.php';
?>
<h2 class = "page-header">Gutscheine</h2>
<?php
//include 'classes/DB.class.php';

$db = new DB();

$db->getGutscheinList();
?>





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