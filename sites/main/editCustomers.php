<?php
//include 'classes/DB.class.php';
include 'classes/securitas.class.php';

echo "<h2 class='page-header'>Kunden Bearbeiten</h2>";

$db = new DB();
if (!empty($_GET['act']) && !empty($_GET['pid'])) {
    $sec = new securitas();
    if ($sec->checkNumeric($_GET['act'], 1, 2) && $sec->checkNumeric($_GET['pid'], 1, PHP_INT_MAX)) {
        $act = $_GET['act'];
        $pid = $_GET['pid'];
        if ($db->setUserStatus($act, $pid)) {
            ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Holly Bananas!</strong>Status wurde geändert
            </div>
            <?php

        } else {
            echo "<p class='bg-danger'>Status wurde nicht geändert. DB Problem</p>";
        }
    }
}


$db->getCustList();
?>