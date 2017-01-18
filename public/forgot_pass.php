<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
require_once("../includes/validation_functions.php");
?>
<?php
$email= "";

if (isset($_POST['submit'])) {
  // Process the form

  // validations
  $required_fields = array("email");
  validate_presences($required_fields);
  $email = $_POST["email"];
  validate_email($email);
  $password = "";
  if (empty($errors)) {
    // Attempt Login
    $email= $_POST["email"];
//$password= $_POST["password"];

    $found_user=find_user_by_email($email);

    if ($found_user){
      //Success.
      $username = $found_user["username"];
      $email = $found_user["email"];
      $register_verify = $found_user["register_verify"];

      $_SESSION["message"] = "We sent a message in your email account, please verify it, and then login!";
      $to      = $email; // Send email to our user
      $subject = 'Forgot Password | Verification'; 
      $message = '
      You have forgoten your password! 

      Please click this link to reset your password:
      http://endritgjeta.com/x-project/public/reset_password.php?email='.$email.'&register_verify='.$register_verify.'
      
'; // Our message above including the link

$headers = 'From: info@endritgjeta.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email

redirect_to("login.php");

} else {
    	      // Failure
  $_SESSION["message"] = "Email address not found!";
}
}
} else {
  // This is probably a GET request 
} // end: if (isset($_POST['submit']))

?>
<?php $layout_context= ""; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">

  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Forgot Password</h2>
    <form action="forgot_pass.php" method="post">
      <p>Please type your email Address:
        <input type="email" name="email" value="" />
      </p>
      <input type="submit" name="submit" value="Submit" />
    </form>
    <br>
    <a href="login.php">Cancel</a>
  </div>

</div> 
<?php include("../includes/layouts/footer.php");
ob_end_flush(); ?>