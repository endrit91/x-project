<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php"); 
require_once("../includes/validation_functions.php");
confirm_logged_in_admin(); 


$admin= find_admin_by_id($_GET["id"]);

if(!$admin){ //na duhet menuja e duhur(id) per te procesuar dhe bere editimin 
	redirect_to("manage_admins.php");
}
//.........................
//form processing
if (isset($_POST['submit'])){
// process the form

// 2. Perform database QUERY


// validations// i bejme qe ne fiillim sepse me pas do i ndryshojme vlerat
$required_fields = array("username", "password"); //sifillim ivendosim ne POST ne array, me qellim validimin
validate_presences($required_fields);
$fields_with_max_lengths=array("username" => 30);
validate_max_lengths($fields_with_max_lengths);

if (empty($errors)){

	// perform update
$id= $admin["id"];
$username=  mysql_escape($_POST['username']);
$hashed_password=  password_encrypt($_POST['password']);

// querin gjithmone e bejme pasi bejme validimet
$query = "UPDATE users SET";
$query.= " username='{$username}', ";
$query.= "password='{$hashed_password}' ";
$query.= "WHERE id= {$id} ";
$query.= "LIMIT 1";


$result= mysqli_query($connection, $query);


// nese deshton merr vlere negative, kjo behet se po te ishte ==1,nese nuk ndryshojme vleren del failed
if($result && mysqli_affected_rows($connection)>=0) {
	
	$_SESSION["message"]= "Admin Updatet Succesfully";//nuk kemi ku ti vendosim sepse eshte redirect
	redirect_to("manage_admins.php");

}else{
	$message = "Admin update Failed!"; 
}

} // end of post submit


}else{
	// ne rast se nuk na vjen nga posti, dmth vje nga GET
}

//..........................
$layout_context= "admin";
include("../includes/layouts/header.php");
?>

<div id="main">
	<div id="navigation">

</div>

<div id="page">

<?php
if(!empty($message)) {
	echo "<div class=\"message\">".htmlentities($message)."</div>";
}

// s kemipse e bejme session sepse jemi te po i njejti script
echo form_errors($errors);
?>

<h2> Edit Admin: <?php echo htmlentities($admin["username"]); ?></h2>
<form action="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>" method="post">
<p>Username: 
<input type="text" name="username" value="<?php echo htmlentities($admin["username"]); ?>"/>
</p>
<p>Password
<input type="password" name="password" value=""/>
</p>

<input type="submit" name="submit" value="Edit Admin"/>
</form>
<br>
<a href="manage_admins.php">Cancel</a>
&nbsp;
&nbsp;
<a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>" onclick="return confirm('Are you sure you want to delete this?');">Delete Admin</a>

	
	</div>
			
</div>

<?php include("../includes/layouts/footer.php");
ob_end_flush(); ?>