<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
require_once("../includes/validation_functions.php");
confirm_logged_in_user(); 
$layout_context= "public"; 
$user_id = $_SESSION['user_id'];
?>
<?php

if (isset($_POST['submit'])){

// validations
	$required_fields = array("description", "visible"); 
	validate_presences($required_fields);

	if (empty($errors)){
		
		$description = mysql_escape($_POST['description']);
		$visible = (int) $_POST["visible"];

		$query = "INSERT INTO posts ( user_id, time_created, description, visible ) VALUES ( {$user_id}, '".date("Y-m-d H:i")."', '{$description}', {$visible} )";

		$result= mysqli_query($connection, $query);
		confirm_query($result);
		$new_post_id = mysqli_insert_id($connection);




		if($result) {
 	 // this is the id of the post 
			$_SESSION["message"]= "Post created, you can insert photos now";
			redirect_to("add_photos.php?post_id=" . urlencode($new_post_id));
		}else{
	$_SESSION["message"]= "Post creation Failed!"; //
	redirect_to("index.php");
}
}
}else{
	// ne rast se nuk na vjen nga posti, dmth vje nga GET
}
?>
<?php
include("../includes/layouts/header_public.php");

?>

<div class="container content_container" id="top_container"> <!--vertical navigation div -->
	<div class="row">
		<div class="col-md-2 col-sm-3 col-xs-12" id="navigation">
			<?php

			?>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-center" id="top_row">

			<?php

			echo message();

			$errors=errors(); 
			echo form_errors($errors);
			?>
			<h2>Add a new post</h2>
			<form action="new_post.php" method="post">
				<p>
					<label>Description</label><br />
					<textarea name="description" rows="10" cols="80" value=""></textarea>  
				</p>

				<p>Public:
					<input type="radio" name="visible" value="0"/>No 
					&nbsp;
					<input type="radio" name="visible" value="1" checked="" />Yes


					<br><br>
					<input type="submit" name="submit" value="Post"/>
				</form>
				<br><br><br>
				<a href="index.php">Cancel</a>
				<div class="statement_block">
				</div>

			</div>
			<div class="col-md-2 col-sm-1 col-xs-12"> <!--right social div -->
			</div>
		</div>
	</div>
</div> <!-- end of first page container, begining is in header_public.php-->

<?php include("../includes/layouts/footer_public.php"); 
ob_end_flush();
?>