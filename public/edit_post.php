<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
require_once("../includes/validation_functions.php");
confirm_logged_in_user(); 
$layout_context= "public"; 

if (isset($_GET["post_id"])){

	$post_id = mysql_escape($_GET["post_id"]);
	$new_post_id = $post_id;
	$post= find_post_by_id($post_id);
} else {
	$_SESSION["message"] = "Invalid Approach"; 
	redirect_to('users_post.php');
}
?>
<?php
if (isset($_POST['submit'])){

// validations
	$required_fields = array("description", "visible"); 
	validate_presences($required_fields);


	if (empty($errors)){
		
		$description = mysql_escape($_POST['description']);
		$visible = (int) $_POST["visible"];

		$query = "UPDATE posts SET";
		$query.= " description='{$description}', ";
		$query.= "visible= {$visible} ";
		$query.= "WHERE id= {$post_id} ";
		$query.= "LIMIT 1";

		$result= mysqli_query($connection, $query);
		confirm_query($result);

		if ($result && mysqli_affected_rows($connection)>=0) {
 	 // this is the id of the post 
			$_SESSION["message"]= "Post updated, you can add new photos now";
			redirect_to("add_photos.php?post_id=" . urlencode($new_post_id));
		}else{
	$_SESSION["message"]= "Post update Failed!"; //
	redirect_to("users_post.php");
}
}
}else{
	
}
?>
<?php
include("../includes/layouts/header_public.php");
?>
<div class="container content_container" id="top_container"> 
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
			<h2>Edit post</h2>
			<form action="edit_post.php?post_id=<?php echo urlencode($post["id"]); ?>" method="post">
				<p>
					<label>Description</label><br />
					<textarea name="description" rows="10" cols="80"><?php echo htmlentities($post["description"]); ?></textarea>  
				</p>

				<p>Public:
					<input type="radio" name="visible" value="0" <?php if($post["visible"]==0) {echo "checked";} ?>/>No 
					&nbsp;
					<input type="radio" name="visible" value="1" <?php if($post["visible"]==1) {echo "checked";} ?>/>Yes
					<br><br>
					<input type="submit" name="submit" value="Update"/>
				</form>
				<br><br><br>
				<a href="users_post.php">Cancel</a>
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