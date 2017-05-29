

<?php

if (!empty($_COOKIE["bananaCremeChoclate"])) {
    $bomb = "boom";
    setcookie("bananaCremeChoclate",$bomb , time() - 3600);
}
$_SESSION = array();
session_destroy();
echo "<p class='bg-success'>Goody bye, lad.</p>";
header('Location: ?page=0');
?>