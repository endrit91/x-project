<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in_user(); 
$layout_context= "public"; 
include("../includes/layouts/header_public.php");
?>
<?php

if (!isset($_GET['post_id'])){
	redirect_to("new_post.php");
}

$new_post_id = mysql_escape($_GET['post_id']);
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
		</p>
		
			<br>

			<label>Upload Photos</label><br />
			<form action="upload.php?post_id=<?php echo urlencode($new_post_id);?>" class="dropzone" id="my-awesome-dropzone"></form>
			
			
			<br>
			<a href="users_post.php"><button type="submit" class="">Upload</button></a>

			<br><br><br>
			<a href="users_post.php">Cancel</a>
			<div class="statement_block">
				<h1 class="statement"></h1>
				<p class="lead"> <p>

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