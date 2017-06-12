
<?php
require_once 'classes/securitas.class.php';
require_once 'classes/DB.class.php';

if (!empty($_GET['pid']) && !empty($_GET['bid'])) {
    $sec = new securitas();
    $db = new DB();
    if ($sec->checkNumeric($_GET['pid'], 1, PHP_INT_MAX) && $sec->checkNumeric($_GET['bid'], 1, PHP_INT_MAX)) {
        //Rechungsnummer generieren
        if (!empty($_SESSION['user'][0])) {
            $username = $_SESSION['user'][0];
        } else {
            header('Location: ?page=666'); //hau ihn raus wenn er nicht eingeloggt ist    
        }
        $pid = $db->getPid($username); //pid wird aus session gehohlt wegen sicherheit, sonst könnt jeder einfach rechnungen von anderen anschaun, um verwirrung bei potenziellen angreifern zu stiften lassen wir pid im GET :)
        $bid = $_GET['bid'];
        $rechnungsNr = "R-" . $bid . "B" . $pid; //rechnungsnummer generieren, genieriert immer dieselbe rechnungsnummer
        echo "<h2 class='page-header'>Rechnung " . $rechnungsNr . "</h2>";
        //getting infos from db
        $custDetails = $db->getCustDetailsAsArray($username);
//        var_dump($custDetails);
        $rechnungsDetails = $db->getRechnungDetails($pid, $bid); //gets Datum, and sum of a Rechnung
        $mwst = round($rechnungsDetails['sum'] * 0.2, 2);
        $gesamtbetrag = round($rechnungsDetails['sum'] + $mwst, 2);
        ?>
        <div class="container col-md-6">
            <p><b><?php echo $custDetails['anrede'] . " " . $custDetails['vorname'] . " " . $custDetails['nachname']; ?></b><br>
                <?php echo $custDetails['strasse']; ?><br>
                <?php echo $custDetails['plz'] . " " . $custDetails['ort']; ?><br> 
                NoCountry 4 Old Bananas
            </p>
        </div>
        <div class="container col-md-6">
            <p><b>The Banana Yoghurt Shop</b><br>
                Plantagenplatz 1<br>
                2599 Muh-Town<br>
                Australia
            </p>
        </div>
        <div class="container col-md-10">
            <h4 class='page-header'>Bestellt am: <?php echo date("d/ m/ Y", strtotime($rechnungsDetails['datum'])); ?></h4>
            <?php $db->getRechnungList($pid, $bid); ?>
            <div class="col-md-6">
                <button class="btn btn-default" onclick="bananaPrint()">Drucken</button>
            </div>
            <div id="summe" class="col-md-4 pull-right">
                <table class="table table-condensed">
                    <tr>
                        <th>Netto</th>
                        <td><?php echo "<span class='glyphicon-euro'></span> " . $rechnungsDetails['sum']; ?></td>
                    </tr>
                    <tr>
                        <th>+20% MwST</th>
                        <td><?php echo "<span class='glyphicon-euro'></span> " . $mwst ?></td>
                    </tr>                    <tr>
                        <th>Gesamtbetrag</th>
                        <th><?php echo "<span class='glyphicon-euro'></span> " . $gesamtbetrag ?></th>
                    </tr>

                </table>
            </div>
        </div>

        <script>
            function bananaPrint() {
                window.print();
            }
        </script>

        <?php
    } else {
        header('Location: ?page=666'); //hau ihn raus 
    }
} else {
    header('Location: ?page=666'); //hau ihn raus
}
    

