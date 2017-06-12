<?php
include 'inc/nav_sec_adminG.php';
?>
<h2 class = "page-header">Gutscheine</h2>
<?php
//include 'classes/DB.class.php';

$db = new DB();

$db->getGutscheinList();
?>




