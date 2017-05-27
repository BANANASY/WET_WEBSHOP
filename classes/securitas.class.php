<?php

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

    public function checkString50($toCheck) {
        if (is_string($toCheck) && strlen($toCheck) > 0 && strlen($toCheck) <= 50) {
            return true;
        } else {
            return false;
        }
    }

    public function checkString255($toCheck) {
        if (is_string($toCheck) && strlen($toCheck) > 0 && strlen($toCheck) <= 255) {
            return true;
        } else {
            return false;
        }
    }

    public function checkEmail($toCheck) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

}
