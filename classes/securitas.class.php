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
        if($db->checkIfUserExists($username)){
            $hash = hash("sha256", $password);
            if($db->userLogin($username, $hash)){
                return true;
            }
        }
        return false;
    }
    
    public function getRole($username){
        $db = new DB();
        if($db->checkIfUserExists($username)){
            return $role = $db->getRole($username);
        }
        return "visitor";
    }

}
