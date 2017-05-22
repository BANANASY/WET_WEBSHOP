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
            $query = "select aid from adresse order by aid desc;";
            $ergebnis = $db->prepare($query);
            $ergebnis->execute();
            $ergebnis->bind_result($aid);
            if ($ergebnis) {
                while ($ergebnis->fetch()) {
                    echo $aid;
                    return $aid;
                }
            }
//            return true; //++toDo++ ändern in return pid erledigt aber nicht schön
        } else {
            return false;
        }
    }
    
    public function insertToUser($username, $password) {
        $db = $this->connect2DB();
        $query = "INSERT INTO user (username, password) 
                  VALUES ('$username', '$password')";
        if ($db->query($query)) {
            $query = "select uid from user order by uid desc;";
            $ergebnis = $db->prepare($query);
            $ergebnis->execute();
            $ergebnis->bind_result($uid);
            if ($ergebnis) {
                while ($ergebnis->fetch()) {
                    echo $uid;
                    return $uid;
                }
            }
//            return true; //++toDo++ ändern in return pid erledigt aber nicht schön
        } else {
            return false;
        }
    }
    
        public function insertToPerson($anrede, $vorname, $nachname, $email, $aid, $uid) {
        $db = $this->connect2DB();
        $query = "INSERT INTO person (anrede, vorname, nachname, email, aid, uid) 
                  VALUES ('$anrede', '$vorname', '$nachname', '$email', '$aid', '$uid')";
        if ($db->query($query)) {
            $query = "select pid from person order by pid desc;";
            $ergebnis = $db->prepare($query);
            $ergebnis->execute();
            $ergebnis->bind_result($pid);
            if ($ergebnis) {
                while ($ergebnis->fetch()) {
                    echo $pid;
                    return $pid;
                }
            }
//            return true; //++toDo++ ändern in return pid erledigt aber nicht schön
        } else {
            return false;
        }
    }
    
    public function getProductsByCategory($cat){
        $db = $this->connect2DB();
        $statement = "SELECT * FROM produkt WHERE kid = " . $cat;
        
        $query = $db->query($statement);
        
        if(!$query){
            echo "Holy Bananoes! There seems to be a problem with the DB!";
        }else{
            while($row = $query -> fetch_object()){
                echo "<div class='productCage'>";
                    echo "<img src='".$row->bild."'>";
                    echo "<table>";
                        echo "<tr><td>Bezeichnung</td><td>".$row->bezeichnung."</td></tr>";
                        echo "<tr><td>Preis </td><td>€ ".$row->preis."</td></tr>";
                        echo "<tr><td>Bewertung</td><td>".$row->bewertung."</td></tr>";
                    echo "</table>";
                echo "</div>";
            }
        }
    }
    
    

}
