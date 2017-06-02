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
//<<<<<<< HEAD
//                echo "<img class='product_img' id='img_" . $row->produktid . "' src='" . $row->bild . "'>";
//                echo "<p class='product_secret' id='product_id'>" . $row->produktid . "</p>";
//                echo "<table class='product_secret'>";
//                echo "<tr><td id='desc_" . $row->produktid . "'>" . $row->bezeichnung . "</td></tr>";
//                echo "<tr><td id='price_" . $row->produktid . "'>€ " . $row->preis . "</td></tr>";
//                echo "<tr><td id='rating_" . $row->produktid . "'>" . $row->bewertung . "</td></tr>";
//                echo "</table>";
//=======
                echo "<img class='product_img draggable' id='img_" . $row->produktid . "' src='" . $row->bild . "'>";
                echo "<p class='product_secret product_id'>" . $row->produktid . "</p>";
                echo "<table class='product_secret'>";
                echo "<tr><td id='desc_" . $row->produktid . "'>" . $row->bezeichnung . "</td></tr>";
                echo "<tr><td id='price_" . $row->produktid . "'>€ " . $row->preis . "</td></tr>";
                echo "<tr><td id='rating_" . $row->produktid . "'>" . $row->bewertung . "</td></tr>";
                echo "</table>";
//>>>>>>> origin/OaschlochNetbeans
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
            echo "<th>Produkt Id</th>";
            echo "<th>Produkt</th>";
            echo "<th>Preis</th>";
            echo "<th>Bewertung</th>";
            echo "<th>Bild</th>";
            echo "<th>Kategorie Id</th>";
            echo "<th>Kategorie</th>";
            echo "<th>Bearbeiten</th>";
            echo "<th>Löschen</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($ergebnis->fetch()) {
                echo "<tr>";
                echo "<td>$produktid</td>";
                echo "<td>$p_bezeichnung</td>";
                echo "<td>$preis</td>";
                echo "<td>$bewertung</td>";
                echo "<td><img class='imgInTable' src='$bild'></td>";
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

}
