<?php 
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in_user(); 
?>

<?php

if (isset($_GET["post_id"])){

	$post_id = mysql_escape($_GET["post_id"]);
	$post= find_post_by_id($post_id);
} else {
	$_SESSION["message"] = "Invalid Approach"; 
	redirect_to('users_post.php');
}



// fillon fshirja
$id=$current_menu["id"];
$query="DELETE FROM posts WHERE id={$post_id} LIMIT 1";

$result= mysqli_query($connection, $query);



if($result && mysqli_affected_rows($connection)==1) {
	
	$_SESSION["message"]= "Post deleted Succesfully";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("users_post.php");

}else{
	$_SESSION["message"]= "Post deletion failed!"; //
	redirect_to("users_post.php");

}
ob_end_flush();	
?>
