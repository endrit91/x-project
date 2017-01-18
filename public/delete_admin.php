<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in_admin(); 
?>

<?php


$admin= find_admin_by_id($_GET["id"]);

if(!$admin){ 
	redirect_to("manage_admins.php");
}


// fillon fshirja
$id=$admin["id"];
$query="DELETE FROM users WHERE id={$id} LIMIT 1";

$result= mysqli_query($connection, $query);



if($result && mysqli_affected_rows($connection)==1) {
	
	$_SESSION["message"]= "Admin deletion Succesfull";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_admins.php");

}else{
	$_SESSION["message"]= "Admin deletion Failed!"; //
	redirect_to("manage_admins.php");
}
ob_end_flush();	
?>