<h2 class="page-header">Mein Konto</h2>
    <ul class="pager">
        <li class="previous"><a href="?page=15">Stammtdaten bearbeiten <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
<?php
//include 'classes/DB.class.php';
include 'classes/securitas.class.php';

//Username aus Session hohlen
if (!empty($_SESSION)) {
    $user = $_SESSION['user'];
    $username = $user[0];


//User Details anzeigen
    if (!empty($username)) {
        $db = new DB();
        if ($db->getCustDetails($username)) {
            
        }
    }
}
?>

<h2>Bestellungen</h2>

<?php

    $db->getSummerizedBestellList($db->getPid($username));

?>

<h2>6. Mein Konto</h2>

<ol>
    <li>Im Bereich „Mein Konto“ kann der User seine Daten einsehen und
        bearbeiten (Stammdaten bearbeiten, neue Zahlungsmöglichkeiten
        hinzufügen). </li>
    <li>Achten Sie drauf, dass sensible Informationen nicht vollständig
        angezeigt werden und beim Ändern von Daten, das Passwort
        verlangt wird.</li>
    <li>Sämtliche Bestellungen des Users werden nach Datum aufwärts
        sortiert angezeigt. Zu jeder Bestellung können die Details
        eingesehen werden. Der User kann zu Jeder Bestellung eine
        Rechnung drucken. In diesem Fall wird eine Rechnungsnummer
        generiert und die Rechnung wird mit Positionen, Datum und
        Anschrift in einem neuen Fenster angezeigt.</li>

</ol>
