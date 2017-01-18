<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
require_once("../includes/validation_functions.php");
?>

<?php
$username= "";

if (isset($_POST['submit'])) {
  // Process the form
if (isset($_POST['remember'])){ // here we create a cookie remember_me if the checkbox is clicked
  setcookie('remember_me', 'checked');
} else {
  setcookie('remember_me', null, time()-36000);
  setcookie('login_time',  time());
  
} 
  // validations
$required_fields = array("username", "password");
validate_presences($required_fields);
$fields_with_max_lengths=array("username"=>30);
validate_max_lengths($fields_with_max_lengths);

if (empty($errors)) {
    // Attempt Login
  $username= $_POST["username"];
  $password= $_POST["password"];

  $found_user=attempt_login($username, $password);

  if ($found_user){
    if (($found_user["status"]!=="1") && ($found_user["is_admin"]!=="1")) {
      $_SESSION["message"] = "Please first check your email adress and verify your account through the link ";   
      redirect_to("login.php");
    }
     //Success.
    $_SESSION["user_id"]=$found_user["id"];
    $_SESSION["username"]=$found_user["username"];
    $_SESSION["is_admin"]=$found_user["is_admin"];
    if($found_user["is_admin"]==="1") {
      redirect_to("admin.php");
    } elseif ($found_user["is_admin"]==="0") {
      redirect_to("index.php");
      
    }

  } else {

      // Failure
    $_SESSION["message"] = "Username/password not found!";
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
    
    <h2>Login</h2>
    <form action="login.php" method="post">
      <p>Username:
        <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
      </p>
      <p>Password:
        <input type="password" name="password" />

        <a href="forgot_pass.php"> Forgot Password?</a>
        <br>
        <input type="checkbox" name="remember" <?php if(isset($_COOKIE['remember_me'])) {
          echo 'checked="checked"';
        }
        else {
          echo '';
        }
        ?> >Remember Me
      </p> 
      <input type="submit" name="submit" value="Submit" />
    </form>
    <br>
    <a href="index.php">Cancel</a>
  </div>

</div>
<?php include("../includes/layouts/footer.php"); 
ob_end_flush(); ?>
