<h2 class="page-header">Mein Konto</h2>
    <ul class="pager">
        <li class="previous"><a href="?page=15">Stammtdaten bearbeiten <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
<?php
//include 'classes/DB.class.php';
include 'classes/securitas.class.php';

//Username aus Session hohlen
if (!empty($_SESSION)) {
    $user = $_SESSION['user'];
    $username = $user[0];


//User Details anzeigen
    if (!empty($username)) {
        $db = new DB();
        if ($db->getCustDetails($username)) {
            
        }
    }
}
?>

<h3 class='page-header'>Bestellungen</h3>

<?php

    $db->getSummerizedBestellList($db->getPid($username));

?>
