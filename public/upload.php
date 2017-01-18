<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
require_once("../includes/validation_functions.php");
confirm_logged_in_user();

$user_id = $_SESSION['user_id'];
$layout_context= "public"; 



$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5

 //insert into the database
   $file_name= mysql_escape($_FILES['file']['name']);




if (isset($_GET['post_id'])){
    $post_id = mysql_escape($_GET['post_id']);
  if (move_uploaded_file($tempFile,$targetFile)){
    $query = "INSERT INTO uploads (post_id, user_id, file_name, time_created ) VALUES ('".$post_id."','".$user_id."','".$file_name."', '".date("Y-m-d H:i")."' )";
  } //6
  $result = mysqli_query($connection, $query);
confirm_query($result);
     
} 
}
ob_end_flush();
?> 