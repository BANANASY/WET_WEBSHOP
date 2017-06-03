<?php

class DB {

    private $host = "localhost";
    private $user = "webshop_user";
    private $password = "wet_123";
    private $dbname = "7048141db1";

//    public function initConnect(){
//        $ret_v = new DB();
//        return $ret_v->connect2DB();
//    }

    public function connect2DB() {
        $conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        return $conn;
    }

    public function userLogin($username, $hash) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT count(username) FROM user WHERE username= ? and password= ?")) {
            $ergebnis->bind_param("ss", $username, $hash);
            $ergebnis->execute();
            $ergebnis->bind_result($matches);
            $ergebnis->fetch();
            if ($matches > 0) {
                $match = true;
            } else {
                $match = false;
            }
            $ergebnis->close();
        }
        $db->close();
        return $match;
    }

    public function checkIfUserExists($username) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT count(uid) FROM user WHERE username = ? ")) {
            $ergebnis->bind_param("s", $username);
            $ergebnis->execute();
            $ergebnis->bind_result($numUserNames);
            $ergebnis->fetch();
            if ($numUserNames > 0) {
                $exists = true;
            } else {
                $exists = false;
            }
            $ergebnis->close();
        }
        $db->close();
        return $exists;
    }

    public function getRole($username) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT role FROM user WHERE username = ? ")) {
            $ergebnis->bind_param("s", $username);
            $ergebnis->execute();
            $ergebnis->bind_result($role);
            $ergebnis->fetch();
            $ergebnis->close();
        }
        $db->close();
        return $role;
    }

    public function getZahlungsinfo() {
        $zahlungsinfos = array();
        $db = $this->connect2DB();
        $query = "select zahlungsart from zahlungsinfo";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($zahlungsinfo);

        if ($ergebnis) {
            while ($ergebnis->fetch()) {
                array_push($zahlungsinfos, $zahlungsinfo);
            }
        }

        $ergebnis->close();
        $db->close();
        return $zahlungsinfos;
    }

    public function insertToAdress($strasse, $plz, $ort) {
        $db = $this->connect2DB();
        $query = "INSERT INTO adresse (strasse, plz, ort) 
                  VALUES ('$strasse', '$plz', '$ort')";
        if ($db->query($query)) {
            $query = "select aid from adresse order by aid desc limit 1;";
            $ergebnis = $db->prepare($query);
            $ergebnis->execute();
            $ergebnis->bind_result($aid);
            if ($ergebnis) {
                while ($ergebnis->fetch()) {
                    return $aid;
                }
            }
        } else {
            return false;
        }
    }

    public function insertToUser($username, $password) {
        $db = $this->connect2DB();
        $query = "INSERT INTO user (username, password) 
                  VALUES ('$username', '$password')";
        if ($db->query($query)) {
            $query = "select uid from user order by uid desc limit 1;";
            $ergebnis = $db->prepare($query);
            $ergebnis->execute();
            $ergebnis->bind_result($uid);
            if ($ergebnis) {
                while ($ergebnis->fetch()) {
                    return $uid;
                }
            }
        } else {
            return false;
        }
    }

    public function insertToPerson($anrede, $vorname, $nachname, $email, $aid, $uid) {
        $db = $this->connect2DB();
        $query = "INSERT INTO person (anrede, vorname, nachname, email, aid, uid) 
                  VALUES ('$anrede', '$vorname', '$nachname', '$email', '$aid', '$uid')";
        if ($db->query($query)) {
            $query = "select pid from person order by pid desc limit 1;";
            $ergebnis = $db->prepare($query);
            $ergebnis->execute();
            $ergebnis->bind_result($pid);
            if ($ergebnis) {
                while ($ergebnis->fetch()) {
                    return $pid;
                }
            }
        } else {
            return false;
        }
    }

    public function insertToZahlung($zid, $pid) {
        $db = $this->connect2DB();
        $query = "INSERT INTO zahlungsinfo_person (zid, pid) 
                  VALUES ('$zid', '$pid')";
        if ($db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductsByCategory($cat) {
        $db = $this->connect2DB();
        $statement = "SELECT * FROM produkt WHERE kid = " . $cat;
        $query = $db->query($statement);
        if (!$query) {
            oh_shit();
        } else {
            echo "<div class='productContent'>";
            while ($row = $query->fetch_object()) {
                echo "<div class='productCage'>";
                echo "<img class='product_img draggable' id='img_" . $row->produktid . "' src='" . $row->bild . "'><br/>";
                echo "<div class='toCart'>In den Warenkorb legen</div>";
                echo "<p class='product_secret product_id'>" . $row->produktid . "</p>";
                echo "<table class='product_secret'>";
                echo "<tr><td id='desc_" . $row->produktid . "'>" . $row->bezeichnung . "</td></tr>";
                echo "<tr><td id='price_" . $row->produktid . "'>€ " . $row->preis . "</td></tr>";
                echo "<tr><td id='rating_" . $row->produktid . "'>" . $row->bewertung . "</td></tr>";
                echo "</table>";
                echo "</div>";
            }
            echo "</div>";
        }
    }

    private function oh_shit() {
        echo "Holy Bananoes! There seems to be a problem with the DB!";
    }

    public function getProductList() {
        echo "<h2>Produkte bearbeiten</h2>";
        $db = $this->connect2DB();
        $query = "SELECT * FROM produkt join kategorie using (kid)";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($kid, $produktid, $p_bezeichnung, $bild, $preis, $bewertung, $k_bezeichnung);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>Bild</th>";
            echo "<th>Produkt Id</th>";
            echo "<th>Produkt</th>";
            echo "<th>Preis</th>";
            echo "<th>Bewertung</th>";

            echo "<th>Kategorie Id</th>";
            echo "<th>Kategorie</th>";
            echo "<th>Bearbeiten</th>";
            echo "<th>Löschen</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                echo "<tr>";
                echo "<td><img class='imgInTable' src='$bild'></td>";
                echo "<td>$produktid</td>";
                echo "<td>$p_bezeichnung</td>";
                echo "<td>$preis</td>";
                echo "<td>$bewertung</td>";
                echo "<td>$kid</td>";
                echo "<td>$k_bezeichnung</td>";
                echo "<td><a href='?page=4&kat=3&ed=$produktid'>Bearbeiten</td>";
                echo "<td><a href='?page=4&kat=1&del=$produktid'>Löschen</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function addProduct($bezeichnung, $bild, $preis, $bewertung, $kid) {
//        echo "<h2>Produkt hinzufügen</h2>";
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("INSERT INTO produkt (bezeichnung, bild, preis, bewertung, kid) VALUES (?, ?, ?, ?, ?);")) {
            $ergebnis->bind_param("ssdii", $bezeichnung, $bild, $preis, $bewertung, $kid);
            if ($ergebnis->execute()) {
                $success = true;
            } else {
                $success = false;
            }
            $ergebnis->close();
            $db->close();
            return $success;
        }
    }

    public function deleteProductById($produktid) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("DELETE FROM produkt WHERE produktid = ?;")) {
            $ergebnis->bind_param("i", $produktid);
            if ($ergebnis->execute()) {
                $success = true;
            } else {
                $success = false;
            }
            $ergebnis->close();
            $db->close();
            return $success;
        }
    }

    public function getImagePathById($produktid) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT bild FROM produkt where produktid = ?;")) {
            $ergebnis->bind_param("i", $produktid);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($pfad);
                if ($ergebnis) {
                    while ($ergebnis->fetch()) {
                        return $pfad;
                    }
                }
                $ergebnis->close();
            }
        }
        $db->close();
    }

    public function getProduktMeta($produktid) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT bezeichnung, bild, preis, bewertung, kid FROM produkt where produktid = ?;")) {
            $ergebnis->bind_param("i", $produktid);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($name, $pfad, $preis, $bewertung, $kid);
                if ($ergebnis) {
                    $produkt = array();
                    while ($ergebnis->fetch()) {
                        $produkt[0] = $name;
                        $produkt[1] = $pfad;
                        $produkt[2] = $preis;
                        $produkt[3] = $bewertung;
                        $produkt[4] = $kid;
                        $produkt[5] = $produktid;
                    }
                }
                $ergebnis->close();
            }
        }
        $db->close();
        if (!empty($produkt)) {
            return $produkt;
        } else {
            return null;
        }
    }

    public function editProduct($produkt) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("UPDATE produkt SET bezeichnung = ?, bild = ?, preis = ?, bewertung = ?, kid = ? WHERE produktid = ?;")) {

            $ergebnis->bind_param("ssdiii", $produkt['name'], $produkt['path'], $produkt['preis'], $produkt['bewertung'], $produkt['kid'], $produkt['produktid']);
            if ($ergebnis->execute()) {
                $success = true;
            } else {
                $success = false;
            }
            $ergebnis->close();
            $db->close();
            return $success;
        }
    }

    public function addGutschein($wert, $datum, $code) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("INSERT INTO gutschein (wert, ablauf_datum, code) VALUES (?, ?, ?);")) {

            $ergebnis->bind_param("iss", $wert, $datum, $code);
            if ($ergebnis->execute()) {
                $success = true;
            } else {
                $success = false;
            }
            $ergebnis->close();
            $db->close();
            return $success;
        }
    }

    public function getGutscheinList() {
        $db = $this->connect2DB();
        $query = "SELECT ablauf_datum, wert, code FROM gutschein order by gid desc";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($datum, $wert, $code);
        if ($ergebnis) {
            echo "<table class='table table-striped'>";
            echo "<thead><tr>";
            echo "<th>Ablauf Datum</th>";
            echo "<th>Wert</th>";
            echo "<th>Code</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                date_default_timezone_set("Europe/Vienna");
                if ($wert == 0 || strtotime($datum) < time()) {
                    echo "<tr class='danger'>";
                } else {
                    echo "<tr>";
                }
                echo "<td>$datum</td>";
                echo "<td>$wert</td>";
                echo "<td>$code</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function getCustList() {
        $db = $this->connect2DB();
        $query = "SELECT
                        pid,
                        anrede,
                        vorname,
                        nachname,
                        email,
                        strasse,
                        plz,
                        ort,
                        username,
                        activ
                    FROM person left join adresse using(aid)
                                left join user using (uid)
                                left join zahlungsinfo_person using (pid)
                    ORDER BY pid DESC;";
        $ergebnis = $db->prepare($query);
        $ergebnis->execute();
        $ergebnis->bind_result($pid, $anrede, $vorname, $nachname, $email, $strasse, $plz, $ort, $username, $active);
        if ($ergebnis) {
            echo "<table class='table table-hover'>";
            echo "<thead><tr>";
            echo "<th>PID</th>";
            echo "<th>Anrede</th>";
            echo "<th>Vorname</th>";
            echo "<th>Nachname</th>";
            echo "<th>Email</th>";
            echo "<th>Strasse</th>";
            echo "<th>PLZ</th>";
            echo "<th>Ort</th>";
            echo "<th>Zahlungsarten</th>";
            echo "<th>Username</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                echo "<tr>";
                echo "<td>$pid</td>";
                echo "<td>$anrede</td>";
                echo "<td>$vorname</td>";
                echo "<td>$nachname</td>";
                echo "<td>$email</td>";
                echo "<td>$strasse</td>";
                echo "<td>$plz</td>";
                echo "<td>$ort</td>";
                echo "<td>";
                $this->getZahlungsarten($pid);
                echo "</td>";
                echo "<td>$username</td>";
                echo "<td>$active</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    /**
     * 
     * @param type $pid person id
     * @return string Liste der Zahlungsarten
     */
    public function getZahlungsarten($pid) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT zahlungsart FROM zahlungsinfo join zahlungsinfo_person using(zid) where pid = ? ;")) {
            $ergebnis->bind_param("i", $pid);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($zahlungsart);
                if ($ergebnis) {
                    echo "<ul>";
                    while ($ergebnis->fetch()) {
                        echo "<li>";
                        echo $zahlungsart;
                        echo "</li>";
                    }
                    echo"</ul>";
                }
                $ergebnis->close();
            }
        }
        $db->close();
    }

}
