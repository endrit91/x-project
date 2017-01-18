<?php 
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
?>

<?php
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['register_verify']) && !empty($_GET['register_verify'])){
    // Verify data
    $email = mysql_escape($_GET['email']); // Set email variable
    $register_verify = mysql_escape($_GET['register_verify']); // Set hash variable
    // now we search if it matches in the database 
$search = "SELECT email, register_verify, status 
FROM users 
WHERE email='".$email."' AND register_verify='".$register_verify."' AND status = '0'"; 
$search = mysqli_query($connection, $search);
 confirm_query($search);
$match  = mysqli_num_rows($search);

  if($match > 0){
        // We have a match, activate the account
        $activate_user="UPDATE users SET status='1' WHERE email='".$email."' AND register_verify='".$register_verify."' AND status = '0'";
        $activate_user = mysqli_query($connection, $activate_user);
        confirm_query($activate_user);
        $_SESSION["message"]="Your account has been activated, you can login now";
        redirect_to("login.php");
    }else{
        // No match -> invalid url or account has already been activated.
        $_SESSION["message"]="You might already have activated your account";
         redirect_to("login.php");
    }
                 
}else{
    // Invalid approach
    $errors[]="Invalid approach, please use the link that has been send to your email.";
    redirect_to("login.php");
}
ob_end_flush();
?>