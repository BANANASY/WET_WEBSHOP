<?php

require_once './classes/DB.class.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of securitas
 *
 * @author pc7227
 */
class securitas {

    public function checkString16($toCheck) {
        if (is_string($toCheck) && strlen($toCheck) > 0 && strlen($toCheck) <= 16 && ctype_alnum($toCheck)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkString50($toCheck) {
        if (is_string($toCheck) && strlen($toCheck) > 0 && strlen($toCheck) <= 50 && ctype_alnum($toCheck)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkString50W($toCheck, $useWhite) {
        if ($useWhite) {
            $toCheck = str_replace(' ', '', $toCheck);
        }
        return $this->checkString50($toCheck);
    }

    public function checkString255($toCheck, $useWhite) {
        if ($useWhite) {
            $toCheck = str_replace(' ', '', $toCheck);
        }
        if (is_string($toCheck) && strlen($toCheck) > 0 && strlen($toCheck) <= 255 && ctype_alnum($toCheck)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkEmail($toCheck) {
        if (filter_var($toCheck, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkNumeric($toCheck, $min, $max) {
        if (isset($toCheck) && is_numeric($toCheck) && $toCheck >= $min && $toCheck <= $max) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($toCheck) {
        if (!empty($toCheck) && ctype_alnum($toCheck) && 7 < strlen($toCheck) && 17 > strlen($toCheck)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin($username, $password) {
        $db = new DB();
        if ($db->checkIfUserExists($username)) {
            $hash = hash("sha256", $password);
            if ($db->userLogin($username, $hash)) {
                return true;
            }
        }
        return false;
    }

    public function getRole($username) {
        $db = new DB();
        if ($db->checkIfUserExists($username)) {
            return $role = $db->getRole($username);
        }
        return "visitor";
    }

    /**
     * 
     * @param type $filename
     * @return returns img name + extension or null if check fails
     */
    public function isImage($filename) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ($ext === 'gif' || $ext === 'png' || $ext === 'jpg') {
            return uniqid() . "." . $ext;
        } else {
            return null;
        }
    }

    /**
     * 
     * @param type $complete enter 0 for complete check 1 for partial check
     * @return string
     */
    public function checkNewProd($complete) {
        $cnt = 0;
        $produkt = array();
        if ($complete == 1) {
            $produkt['produktid'] = $_POST['produktid'];
        }
        if ($this->checkNumeric($_POST['kategorie'], 1, 5)) {
            $produkt['kid'] = $_POST['kategorie'];
            $cnt++;
        }
        if ($this->checkString50W($_POST['bezeichnung'], true)) {
            $produkt['name'] = $_POST['bezeichnung'];
            $cnt++;
        }
        if ($this->checkNumeric($_POST['preis'], 0, 5000)) {
            $produkt['preis'] = $_POST['preis'];
            $cnt++;
        }
        if ($this->checkNumeric($_POST['bewertung'], 0, 5)) {
            $produkt['bewertung'] = $_POST['bewertung'];
            $cnt++;
        }
        if (!empty($_FILES['bild']['name'])) {
            if ($_FILES['bild']['error'] == 0) {
                if ($this->isImage($_FILES['bild']['name']) !== null) {
                    $bild = $this->isImage($_FILES['bild']['name']);
                    switch ($produkt['kid']) {
                        case 1:
                            $produkt['path'] = "pictures/banana/" . $bild;
                            break;
                        case 2:
                            $produkt['path'] = "pictures/yoghurt/" . $bild;
                            break;
                        case 3:
                            $produkt['path'] = "pictures/egg/" . $bild;
                            break;
                        case 4:
                            $produkt['path'] = "pictures/rice/" . $bild;
                            break;
                        case 5:
                            $produkt['path'] = "pictures/costumes/" . $bild;
                            break;
                    }
                    if (move_uploaded_file($_FILES['bild']['tmp_name'], $produkt['path'])) {
                        $cnt++;
//                    echo "<p class='bg-success'>Bild upgeloaded. Neuer name = " . $bild."</p>";
                    } else {
                        echo "<p class='bg-danger'>Couldn't move bild</p>";
                    }
                } else {
                    echo "<p class='bg-danger'>Not an image. Only jpg, png and gifs allowed.</p>";
                }
            } else {
                echo "<p class='bg-danger'>File error. Propably the uploaded image is too large.</p>";
            }
        } else { //altes bild verwenden
            $produkt['path'] = $_POST['oldBild'];
        }
        if ($complete == 0) {
            if ($cnt == 5) {
                return $produkt;
            } else
                return null;
        } else
            return $produkt;
    }

}
