<?php

class DB {

    private $host = "localhost";
    private $user = "webshop_user";
    private $password = "wet_123";
    private $dbname = "7048141db1";

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

    public function checkIfUserActive($username) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("select activ from person join user using(uid) where username= ? ")) {
            $ergebnis->bind_param("s", $username);
            $ergebnis->execute();
            $ergebnis->bind_result($status);
            $ergebnis->fetch();
            if ($status == 1) {
                $letPass = true;
            } else {
                $letPass = false;
            }
            $ergebnis->close();
        }
        $db->close();
        return $letPass;
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

    public function getPid($username) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("select pid from person join user using (uid) where username = ? ")) {
            $ergebnis->bind_param("s", $username);
            $ergebnis->execute();
            $ergebnis->bind_result($pid);
            $ergebnis->fetch();
            $ergebnis->close();
        }
        $db->close();
        return $pid;
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
                echo "<tr><td class='product_description' id='desc_" . $row->produktid . "'>" . $row->bezeichnung . "</td></tr>";
                echo "<tr><td class='product_price' id='price_" . $row->produktid . "'>€ " . $row->preis . "</td></tr>";
                echo "<tr><td class='product_rating' id='rating_" . $row->produktid . "'>" . $row->bewertung . "</td></tr>";
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
        echo "<h2 class='page-header'>Produkte bearbeiten</h2>";
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
        $query = "SELECT distinct
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
                    FROM person join adresse using(aid)
                                join user using (uid)
                                join zahlungsinfo_person using (pid)
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
            echo "<th>Bestellungen</th>";
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
                if ($active == 1) {
                    echo "<td><a href=?page=5&act=2&pid=$pid>Deaktivieren</td>";
                } else {
                    echo "<td><a href=?page=5&act=1&pid=$pid>Aktivieren</td>";
                }
                echo "<td><a href=?page=14&pid=$pid>Details</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        $ergebnis->close();
        $db->close();
    }

    public function getOneCust($pid) {
        $db = $this->connect2DB();
        $query = "SELECT
                        anrede,
                        vorname,
                        nachname,
                        email,
                        strasse,
                        plz,
                        ort,
                        username,
                        activ
                    FROM person join adresse using(aid)
                                join user using (uid)
                                join zahlungsinfo_person using (pid)
                    where pid = ?
                    ORDER BY pid DESC limit 1;";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("i", $pid);
        $ergebnis->execute();
        $ergebnis->bind_result($anrede, $vorname, $nachname, $email, $strasse, $plz, $ort, $username, $active);
        if ($ergebnis) {
//            echo "<div class='jumbotron'>";

            while ($ergebnis->fetch()) {
                echo "<ul class = 'list-group col-md-12'>";
                echo "<li class = 'list-group-item col-md-9'>";
                echo "<span class = 'badge'>";

                echo "Username: " . $username;
                echo "</span>";
                echo "<h3><small>" . $anrede . "</small> " . $vorname . " " . $nachname . "</h3>";
                echo "<p>&emsp;" . $email . "<br>";
                echo "&emsp;" . $strasse . "<br>";
                echo "&emsp;" . $plz . " " . $ort . "</p>";
                echo "</li>";
                echo "<li class = 'list-group-item col-md-3 active'>";
                echo "<span class = 'badge'>";
                if ($active == 1) {
                    echo "Status: Aktiviert";
                } else {
                    echo "Status: Deaktiviert";
                }
                echo "</span>";
                echo "<h4>Zahlungsarten</h4>";
                $this->getZahlungsarten($pid);
                echo "</li>";
                echo "</ul>";
            }
//            echo "</div>";
        }
        $ergebnis->close();
        $db->close();
        return true;
    }

    public function getCustDetails($username) {
        $db = $this->connect2DB();
        $query = "SELECT distinct anrede, vorname, nachname, email, strasse, plz, ort, pid "
                . "FROM person "
                . "join adresse using(aid) "
                . "join user using (uid) "
                . "join zahlungsinfo_person using (pid) "
                . "where username = ?;";
        $ergebnis = $db->prepare($query);
        $ergebnis->bind_param("s", $username);
        $ergebnis->execute();
        $ergebnis->bind_result($anrede, $vorname, $nachname, $email, $strasse, $plz, $ort, $pid);
        if ($ergebnis) {
            while ($ergebnis->fetch()) {
                echo "<ul class = 'list-group col-md-12'>";
                echo "<li class = 'list-group-item col-md-9'>";
                echo "<span class = 'badge username'>";

                echo $username;
                echo "</span>";
                echo "<h3><small>" . $anrede . "</small> " . $vorname . " " . $nachname . "</h3>";
                echo "<p>&emsp;" . $email . "<br>";
                echo "&emsp;" . $strasse . "<br>";
                echo "&emsp;" . $plz . " " . $ort . "</p>";
                echo "</li>";
                echo "<li class = 'list-group-item col-md-3 active'>";
                echo "<h4>Zahlungsarten</h4>";
                $this->getZahlungsarten($pid);
                echo "</li>";
                echo "<li class = 'list-group-item col-md-3 '>";
                echo "<h6>Zahlungsart hinzufügen</h6>";
                echo "<form class = 'form-horizontal check-password' action = '?page=2' method = 'post'>";
                echo "<div class='form-group'>";
                echo "<select class='form-control' name='credit' required id='credit'>";
                $zahlungsarten = $this->getZahlungsinfo();
                $id = 1;
                foreach ($zahlungsarten as $zahlungsart) {
                    echo "<option value=" . $id . ">" . $zahlungsart . "</option>";
                    $id++;
                }
                echo "</select>";
                echo "<button id='submit' value='zahlungsart' type='submit' class='btn btn-default'>Zahlungsart hinzufügen</button></div></div></form>";
                echo "</li>";
                echo "</ul>";
            }
        }
        $ergebnis->close();
        $db->close();
        return true;
    }

    /**
     * 
     * @param type $pid person id
     * @return string Liste der Zahlungsarten
     */
    public function getZahlungsarten($pid) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT zahlungsart FROM zahlungsinfo join zahlungsinfo_person using(zid) where pid = ?;
")) {
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
    
    public function getZahlungsdatenAsOptions($pid){
        $db = $this->connect2DB();

        if ($ergebnis = $db->prepare("SELECT zahlungsart, zid FROM zahlungsinfo join zahlungsinfo_person using(zid) where pid = ?;
")) {
            $ergebnis->bind_param("i", $pid);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($zart, $zid);
                if ($ergebnis) {
                    
                    while ($ergebnis->fetch()) {
                        echo "<option value='".$zid."'>";
                        echo $zart;
                        echo "</option>";
                    }
                  
                }
                $ergebnis->close();
            }
        }
        $db->close();
    }

    public function setUserStatus($act, $pid) {
        if ($act == 1) {
            $query = "update person set activ = 1 where pid = ?;
";
        } elseif ($act == 2) {
            $query = "update person set activ = 0 where pid = ?;
";
        } else {
            return false;
        }
        $success = false;
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare($query)) {
            $ergebnis->bind_param("i", $pid);
            if ($ergebnis->execute()) {
                $success = true;
            }
            $ergebnis->close();
        }
        $db->close();
        return $success;
    }

    public function getBestellList($pid) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("SELECT produktid, bezeichnung,anzahl,preis, datum, zahlungsart, gid, bid
                                                FROM bestellungen
                                                join produkt using (produktid)
                                                join zahlungsinfo using(zid)
                                                WHERE pid = ?")) {
            $ergebnis->bind_param("i", $pid);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($produktid, $bezeichnung, $anzahl, $preis, $datum, $zahlungsart, $gid, $bid);
                if ($ergebnis) {
                    echo "<table class='table table-hover'>";
                    echo "<thead><tr>";
                    echo "<th>Produkt</th>";
                    echo "<th>Anzahl</th>";
                    echo "<th>Einzelpreis</th>";
                    echo "<th>Gesamtpreis</th>";
                    echo "<th>Datum</th>";
                    echo "<th>Zahlungsart</th>";
                    echo "<th>Gutschein</th>";
                    echo "<th>Löschen</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($ergebnis->fetch()) {
                        echo "<tr>";
                        echo "<td>$bezeichnung</td>";
                        echo "<td>$anzahl</td>";
                        echo "<td>€ " . $preis . "</td>";
                        echo "<td>€ " . $preis * $anzahl . "</td>";
                        echo "<td>$datum</td>";
                        echo "<td>$zahlungsart</td>";
                        echo "<td>";
                        if (!empty($gid) && $gid > 0) {
                            echo "eingelöst";
                        }
                        echo "</td>";
                        echo "<td><a href=?page=14&pid=$pid&bid=$bid&produktid=$produktid>Löschen</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                $ergebnis->close();
            }
        }
        $db->close();
    }
    
    // this function inserts a new order with either zid or gid, not both
    public function insertBestellung($withZid, $bid, $produktid, $pid, $id, $amount){
        if($withZid){
            $zid = $id;
            //  bid 	produktid 	pid 	datum 	zid 	anzahl 	gid
            $db = $this->connect2DB();
            $stmt = "INSERT INTO bestellungen (bid, produktid, pid, zid, anzahl) VALUES (?, ?, ?, ?, ?);";
            
            if ($ergebnis = $db->prepare($stmt)) {

                $ergebnis->bind_param("iiiii", $bid, $produktid, $pid, $zid, $amount);
                if ($ergebnis->execute()) {
                    $success = true;
                } else {
                    $success = false;
                }
                $ergebnis->close();
                $db->close();
                return $success;
            }
        }else{
            $gid = $id;
            
            $db = $this->connect2DB();
            $stmt = "INSERT INTO bestellungen (bid, produktid, pid, anzahl, gid) VALUES (?, ?, ?, ?, ?);";
            
            if ($ergebnis = $db->prepare($stmt)) {

                $ergebnis->bind_param("iiiii", $bid, $produktid, $pid, $amount, $gid);
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
        
    }
    
    // this function returns the latest (highest) order id
    public function getLatestBid () {
        $db = $this->connect2DB();
        $stmt = "SELECT MAX(bid) FROM bestellungen";
        if ($ergebnis = $db->prepare($stmt)) {
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($bid_max);
                if ($ergebnis) {
                    while ($ergebnis->fetch()) {
                        if($bid_max > 0){
                            $ergebnis->close();
                            $db->close();
                            return $bid_max;
                        }else{
                            $ergebnis->close();
                            $db->close();
                            return -1;
                        }
                    }                      
                }
            }
        } 
    }

    public function deleteBestellung($bid, $pid, $produktid) {
        $db = $this->connect2DB();
        if ($ergebnis = $db->prepare("DELETE FROM bestellungen WHERE produktid = ? and pid = ? and bid = ?;")) {
            $ergebnis->bind_param("iii", $produktid, $pid, $bid);
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
    
    public function checkCoupon ($code) {
        $db = $this->connect2DB();
        $stmt = "SELECT COUNT(*) FROM gutschein WHERE code = ?;";
        if ($ergebnis = $db->prepare($stmt)) {
            $ergebnis->bind_param("s", $code);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($test);
                if ($ergebnis) {
                    
                    while ($ergebnis->fetch()) {
                        if($test > 0){
                            $ergebnis->close();
                            $db->close();
                            return true;
                        }else{
                            $ergebnis->close();
                            $db->close();
                            return false;
                        }
                    }
                  
                }
                
            }
        }
       
    }
    
    public function getCouponValue ($code) {
        $db = $this->connect2DB();
        $stmt = "SELECT wert, ablauf_datum FROM gutschein WHERE code = ?;";
        if ($ergebnis = $db->prepare($stmt)) {
            $ergebnis->bind_param("s", $code);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($value, $exp_date);
                if ($ergebnis) {
                    
                    while ($ergebnis->fetch()) {
                        $exp_date = strtotime($exp_date);
                        if($value > 0 && time() < $exp_date ){
                            $ergebnis->close();
                            $db->close();
                            return $value;
                        }else{
                            $ergebnis->close();
                            $db->close();
                            return -1;
                        }
                    }         
                }  
            }
        }     
    }
    
    //gets coupon id
    public function getCouponId ($code) {
        $db = $this->connect2DB();
        $stmt = "SELECT gid FROM gutschein WHERE code = ?;";
        if ($ergebnis = $db->prepare($stmt)) {
            $ergebnis->bind_param("s", $code);
            if ($ergebnis->execute()) {
                $ergebnis->bind_result($gid);
                if ($ergebnis) {
                    
                    while ($ergebnis->fetch()) {
                        if($gid > 0){
                            $ergebnis->close();
                            $db->close();
                            return $gid;
                        }else{
                            $ergebnis->close();
                            $db->close();
                            return -1;
                        }
                    }         
                }  
            }
        }     
    }
    
    //updates new value of a coupon
    public function decreaseCouponValue($code, $newCoupon_value){
        $db = $this->connect2DB();
        $stmt = "UPDATE gutschein SET wert = ? WHERE gutschein.code = ?;";
        if ($ergebnis = $db->prepare($stmt)) {
            $ergebnis->bind_param("ds", $newCoupon_value,$code);
            if ($ergebnis->execute()) {
                $ergebnis->close();
                $db->close();
                return true;
            }else{
                $ergebnis->close();
                $db->close();
                return false;
            }
        }
    }
}
