<a href="index.php">Back</a>
        <?php
        INCLUDE "./config/DB.php";

        $conn = new DB();

        if ($conn->connect2DB()) {
            echo "<br />DB connected";
            $db = $conn->connect2DB();
            $stmt = "SELECT * FROM gesamt_rechnungen;";
            $ergebnis = $db->prepare($stmt);
            $ergebnis->execute();
            $ergebnis->bind_result($anrede, $vorname, $nachname, $strasse, $plz, $ort, $zahlungsart, $total, $netto, $datum, $bid, $pid);

            if ($ergebnis) {
                while ($ergebnis->fetch()) {
                    echo $anrede . $vorname . $nachname . $strasse . $plz . $ort . $zahlungsart . $total . $netto . $datum . $bid . $pid;
                }
            }
            $ergebnis->close();
            $db->close();
        } else {
            echo "DB connection failed.";
        }
        ?>

