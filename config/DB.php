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

    public function userLogin($userName, $userPasswort) {
        //++implemennt++
    }

    public function checkIfUserExists($username) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT count(uid) FROM user WHERE username = ? ")) {
            $ergebnis->bind_param("s", $username);
            $ergebnis->execute();
            $ergebnis->bind_result($numUserNames);
            $ergebnis->fetch();
            if($numUserNames>0){
                $exists = true;
            } else {
                $exists = false;
                if (!$exists){
                }

            }
            $ergebnis->close();
        }
        $db->close();
        return $exists;
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
            while ($row = $query->fetch_object()) {
                echo "<div class='productCage'>";
                    echo "<img class='product_img' id='img_". $row->produktid ."' src='".$row->bild."'>";
                    echo "<p class='product_secret' id='product_id'>".$row->produktid."</p>";
                    echo "<table class='product_secret'>";
                        echo "<tr><td id='desc_". $row->produktid ."'>".$row->bezeichnung."</td></tr>";
                        echo "<tr><td id='price_". $row->produktid ."'>€ ".$row->preis."</td></tr>";
                        echo "<tr><td id='rating_". $row->produktid ."'>".$row->bewertung."</td></tr>";
                    echo "</table>";
                echo "</div>";
            }
        }
    }

    private function oh_shit() {
        echo "Holy Bananoes! There seems to be a problem with the DB!";
    }

}
