<?php

include "classes/securitas.class.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author pc7227
 */
class user {

//    in table person
    private $pid;
    private $anrede;
    private $vorname;
    private $nachname;
    private $email;
//    in table adresse
    private $aid;
    private $strasse;
    private $plz;
    private $ort;
// in table user
    private $UID;
    private $username;
    private $password;
    private $role;
//  in table zahlungsinfo_person
    private $zid; //als array
//  allgood
    private $allgood = true;

    public function __construct($anrede, $vorname, $nachname, $email, $strasse, $plz, $ort, $username, $password1, $password2, $zid) {
        $this->setAnrede($anrede);
        $this->setVorname($vorname);
        $this->setNachname($nachname);
        $this->setEmail($email);
        $this->setStrasse($strasse);
        $this->setPlz($plz);
        $this->setOrt($ort);
        $this->setUsername($username);
        $this->setPassword($password1, $password2);
        $this->setZid($zid);
    }

    private function setAnrede($anrede) {
        $sec = new Securitas();
        if ($sec->checkNumeric($anrede, 1, 3)) {
            switch ($anrede) {
                case 1:
                    $this->anrede = "Mr";
                    break;
                case 2:
                    $this->anrede = "Mrs";
                case 3:
                    $this->anrede = "Erwin";
            }
        } else {
            $this->allgood = false;
            echo "Invalid Anrede. Don't fuck around with our code plz.<br>";
        }
    }

    private function setVorname($vorname) {
        $sec = new Securitas();
        if ($sec->checkString50($vorname)) {
            $this->vorname = $vorname;
        } else {
            $this->allgood = false;
            echo "Invalid Vorname. Vorname must be below 50 charcters.<br>";
        }
    }

    private function setNachname($nachname) {
        $sec = new Securitas();
        if ($sec->checkString50($nachname)) {
            $this->nachname = $nachname;
        } else {
            $this->allgood = false;
            echo "Invalid Nachname. Nachname must be below 50 characters.<br>";
        }
    }

    private function setEmail($email) {
        $sec = new Securitas();
        if ($sec->checkEmail($email)) {
            $this->email = $email;
        } else {
            $this->allgood = false;
            echo "Invalid Email. Enter a valid Email.<br>";
        }
    }

    private function setStrasse($strasse) {
        $sec = new Securitas();
        if ($sec->checkString255($strasse, true)) {
            $this->strasse = $strasse;
        } else {
            $this->allgood = false;
            echo "Invalid Strasse. Strasse must be max 255 characters wide.<br>";
        }
    }

    private function setPlz($plz) {
        $sec = new Securitas();
        if ($sec->checkNumeric($plz, 1000, 10000)) {
            $this->plz = $plz;
        } else {
            $this->allgood = false;
            echo "Invalid PLZ. PLZ must be between 1000 and 10000.<br>";
        }
    }

    private function setOrt($ort) {
        $sec = new Securitas();
        if ($sec->checkString255($ort, false)) {
            $this->ort = $ort;
        } else {
            $this->allgood = false;
            echo "Invalid Ort. Ort must be max 255 characters wide.<br>";
        }
    }

    private function setUsername($username) {
        $sec = new Securitas();
        if ($sec->checkString16($username)) {
            $db = new DB();
            if (!$db->checkIfUserExists($username)) {
                $this->username = $username;
            } else {
                $this->allgood = false;
                echo "Invalid Username. Username must be unique.<br>";
            }
        } else {
            $this->allgood = false;
            echo "Invalid Username. Username must be max 16 characters wide.<br>";
        }
    }

    private function setPassword($password1, $password2) {
        $sec = new Securitas();
        if ($password1 === $password2) {
            if ($sec->checkPassword($password1)) {
                $hash = hash("sha256", $password1);
                $this->password = $hash;
            } else {
                $this->allgood = false;
                echo "Invalid Password. Didn't match criteria. Alphanumeric, min 8, max 16.<br>";
            }
        } else {
            $this->allgood = false;
            echo "Invalid Password. No match.<br>";
        }
    }

    private function setZid($zid) {
        $sec = new Securitas();
        if ($sec->checkNumeric($zid, 0, 2)) {
            $this->zid = $zid;
        } else {
            $this->allgood = false;
            echo "Invalid Zahlungsmethode. Don't fuck around with our code plz.<br>";
        }
    }

    //++implement security++
    public function addToDB() {
        if ($this->allgood) {
            $db = new DB();
            $this->aid = $db->insertToAdress($this->strasse, $this->plz, $this->ort);
            echo "adresse added<br>";
            $this->UID = $db->insertToUser($this->username, $this->password);
            echo "user added<br>";
            $this->pid = $db->insertToPerson($this->anrede, $this->vorname, $this->nachname, $this->email, $this->aid, $this->UID);
            echo "person added<br>";
            $success = $db->insertToZahlung($this->zid, $this->pid);
            if ($success) {
                echo "zahlungsinfo added<br>";
            }
            return true;
        } else {
            return false;
        }
    }

}
