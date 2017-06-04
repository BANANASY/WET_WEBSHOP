<h2 class="page-header">Mein Konto</h2>
<?php
include 'classes/DB.class.php';
include 'classes/securitas.class.php';

//Username aus Session hohlen
if (!empty($_SESSION)) {
    $user = $_SESSION['user'];
    $username = $user[0];

    if (!empty($_POST['credit'])) {
        $sec = new securitas();
        if ($sec->checkNumeric($_POST['credit'], 1, 3)) {
            $zid = $_POST['credit'];
            $db = new DB();
            $pid = $db->getPid($username);
            if ($db->insertToZahlung($zid, $pid)) {
                ?>
<!--                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Holly Bananas!</strong>Die Zahlungsart wurde hinzugefügt.
                </div>-->
                <?php
            }
        }
    }

//User Details anzeigen
    if (!empty($username)) {
        $db = new DB();
        if ($db->getCustDetails($username)) {
            
        }
    }
}
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
