<?php
session_start();
require_once '../classes/securitas.class.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!empty($_POST['pw'])){
    echo "passed";
} else {
    echo "bullshit";
}
