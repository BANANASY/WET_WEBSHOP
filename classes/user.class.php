<?php

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

    

    public function __construct($anrede, $vorname, $nachname, $email, $strasse, $plz, $ort, $username, $password1, $password2, $zid) {
        $this->setAnrede($anrede);
        $this->setVorname($vorname);
        $this->setNachname($nachname);
        $this->setEmail($email);
        $this->setStrasse($strasse);
        $this->setPlz($plz);
        $this->ort = $ort;
        $this->username = $username;
        $this->setPassword($password1, $password2);
        $this->setZid($zid);
    }

    private function setAnrede($anrede) {
        if (is_numeric($anrede)) {
            switch ($anrede) {
                case 1:
                    $this->anrede = "Mr";
                    break;
                case 2:
                    $this->anrede = "Mrs";
                case 3:
                    $this->anrede = "Erwin";
            }
        }
    }

    private function setVorname($vorname) {
        $this->vorname = $vorname;
    }

    private function setNachname($nachname) {
        $this->nachname = $nachname;
    }

    private function setEmail($email) {
        $this->email = $email;
    }

    private function setStrasse($strasse) {
        $this->strasse = $strasse;
    }

    private function setPlz($plz) {
        $this->plz = $plz;
    }

    private function setOrt($ort) {
        $this->ort = $ort;
    }

    private function setUsername($username) {
        $this->username = $username;
    }

    private function setPassword($password1, $password2) {
        if ($password1==$password2){
            $this->password = $password1;
        }
    }

    private function setZid($zid) {
        $this->zid = $zid;
    }
    
    //++implement security++
    public function addToDB(){
        $db = new DB();
        $this->aid = $db->insertToAdress($this->strasse, $this->plz, $this->ort);
        echo "adresse added<br>";
        $this->UID = $db->insertToUser($this->username, $this->password);
        echo "user added<br>";
        $this->pid = $db->insertToPerson($this->anrede, $this->vorname, $this->nachname, $this->email, $this->aid, $this->UID);
        echo "person added<br>";
        
        return true;
        }
    }


