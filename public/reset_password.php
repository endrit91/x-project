<?php 
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
require_once("../includes/validation_functions.php");
?>
<?php
if (isset($_POST['submit'])){
if (!isset($_POST['email']) || !isset($_POST['register_verify']) ){ // the values we got from GET, we stored in the form
    $_SESSION["message"] = "Invalid approach, please use the link that has been send to your email.";
    redirect_to("login.php");
}
    $email = mysql_escape($_POST['email']); // Set email variable
    $register_verify = mysql_escape($_POST['register_verify']); // Set hash variable
    // now we search if it matches in the database 
    $search = "SELECT email, register_verify, status, password 
    FROM users 
    WHERE email='".$email."' AND register_verify='".$register_verify."'"; 
    $search = mysqli_query($connection, $search);
    confirm_query($search);
    $match  = mysqli_num_rows($search);
    mysqli_free_result($search);
    if($match > 0){
      // We have a match, now we proceed with the form
        $required_fields = array("password", "password_1"); 
        validate_presences($required_fields);
        $fields_with_max_lengths=array("password" => 100);
        $fields_with_min_lengths=array("password" => 5);
        validate_max_lengths($fields_with_max_lengths);
        validate_min_lengths($fields_with_min_lengths);
        if ($_POST["password"]!==$_POST["password_1"]) {
            $_SESSION["message"]= "You probably typed different passwords";
            redirect_to("reset_password.php");
        }
        if (empty($errors)){

            // perform update
            $hashed_password = password_encrypt($_POST["password"]);

            $query = "UPDATE users SET ";
            $query.= "password = '{$hashed_password}' ";
            $query.= "WHERE email= '{$email}' ";
            $query.= "LIMIT 1";


            $result= mysqli_query($connection, $query);
            confirm_query($result);


            if($result && mysqli_affected_rows($connection)>=0) {

                $_SESSION["message"] = "Password updatet Succesfully";
                redirect_to("login.php");
            } else {
                $_SESSION["message"] = "Password update Failed";
                redirect_to("reset_password.php");
            }
        } // end of if empty errors 
    } 
} else {

}

?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">

  </div>
  <div id="page">
     <?php
     echo message(); ?>
     <?php echo form_errors($errors); ?>

     <h2>Reset Password</h2>
     <form action="reset_password.php" method="POST">
        <p>Password:
            <input type="password" name="password" value="" />
        </p> 
        <p>Confirm Password:
            <input type="password" name="password_1" value="" />
        </p> 
        <?php if (isset($_GET['email']) && isset($_GET['register_verify'])){?>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']);?>">
        <input type="hidden" name="register_verify" value="<?php echo htmlspecialchars($_GET['register_verify']);?>">
        <?php } ?>
        <input type="submit" name="submit" value="Save" />
    </form>
    <br />
    <a href="login.php">Cancel</a>
</div>
</div>

<?php include("../includes/layouts/footer.php"); 
ob_end_flush(); ?>
