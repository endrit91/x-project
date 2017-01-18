<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/functions.php");

 ?>

<?php
$_SESSION["user_id"] = null;
$_SESSION["username"] = null;
$_COOKIE["remember_me"]= null;
redirect_to("login.php");
ob_end_flush();
?>