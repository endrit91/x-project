<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
//confirm_logged_in();
require_once("../includes/validation_functions.php");
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  // validations
  $required_fields = array("username","email","password", "password_1");
  validate_presences($required_fields);
  $fields_with_max_lengths=array("username"=>40);
  $fields_with_min_lengths=array("username"=>5, "password"=>5);
  validate_max_lengths($fields_with_max_lengths);
  validate_min_lengths($fields_with_min_lengths);

  $email = $_POST["email"];
  validate_email($email);

  if ($_POST["password"]!==$_POST["password_1"]) {
    $_SESSION["message"]= "You probably typed different passwords";
    redirect_to("new_user.php");

  } elseif (empty($errors))  {
      // Perform Create
    $username = mysql_escape($_POST["username"]);

    $existing_user=find_user_by_username($username);
    if ($existing_user){
      $_SESSION["message"]= "Username already taken";
      redirect_to("new_user.php");
    }
    $existing_email=find_user_by_email($email);
    if ($existing_email){
      $_SESSION["message"]= "Email is already registererd";
      redirect_to("new_user.php");
    }
    $password = mysql_escape($_POST["password"]);
    $email= mysql_escape($_POST["email"]);
    $hashed_password = password_encrypt($_POST["password"]);
    $register_verify = password_encrypt( rand(1000,5000)); // this is the verification hashed code we will send to the user

    $query  = "INSERT INTO users (";
    $query .= "  username, password, email, register_verify, is_admin ";
    $query .= ") VALUES (";
    $query .= "  '{$username}', '{$hashed_password}', '{$email}', '{$register_verify}', 0 ";
    $query .= ")";
    $result = mysqli_query($connection, $query);
    
    if ($result) {
      // Success
      $_SESSION["message"] = "Sign up succesful. --> We sent a message in your email account, please verify it, and then login!";
      $to      = $email; // Send email to our user
      $subject = 'Signup | Verification'; 
      $message = '
      Thanks for signing up!
      Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

      ------------------------
      Username: '.$username.'
      Password: '.$password.'
      ------------------------

      Please click this link to activate your account:
      http://endritgjeta.com/x-project/public/verify.php?email='.$email.'&register_verify='.$register_verify.'
      
'; // Our message above including the link
$headers = 'From: info@endritgjeta.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email

redirect_to("login.php");
} else {
      // Failure
  $_SESSION["message"] = "Signup failed ";
    }
  }
} else { // This is probably a GET request

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
    
    <h2>Sign Up</h2>
    <form action="new_user.php" method="post">
      <p>Username:
        <input type="text" name="username" value="" />
      </p>
      <p>Email:
        <input type="email" name="email" value="" />
      </p>
      <p>Password:
        <input type="password" name="password" />
      </p> 
      <p>Password:
        <input type="password" name="password_1" />
      </p> 

      <input type="submit" name="submit" value="Sign up" />
    </form>
    <br />
    <a href="index.php">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php");
ob_end_flush(); ?>