<?php
ob_start();
require_once("../includes/sessions.php"); 
require_once("../includes/db_connection.php"); 
require_once("../includes/functions.php");
confirm_logged_in_admin(); 

$admins_result= query_all_admins();
$layout_context= "admin"; 
include("../includes/layouts/header.php");
?>

<div id="main">
	<div id="navigation">
<br>
<a href="admin.php"> &laquo; Main Menu</a> <br>


</div>

<div id="page">

	<?php
	echo message();

	?>
	
	<h2> Manage Admins And Users  </h2>

	<table>
		<tr>
			<th style="text-align: left; width: 200px;">Username</th>
			<th style="text-align: left; width: 200px;">Role</th>
			<th colspan="2" style="text-align: left;">Actions</th>
		</tr>
		<?php while($admins= mysqli_fetch_assoc($admins_result)) { ?>
		<tr>
			<td><?php echo htmlentities($admins["username"]);?>

			</td>
			<td><?php if($admins["is_admin"]==="1"){echo "Admin"; } else { echo  "User";  }?>
				

			</td>

			<td><a href="edit_admin.php?id=<?php echo urlencode($admins["id"]); ?>">Edit</a><a href="delete_admin.php?id=<?php echo urlencode($admins["id"]); ?>"  onclick="return confirm('Are you sure you want to delete this?');"> &nbsp; Delete</a></td>
			
		</tr>
		
			
		<?php } ?>
	</table>
		<br>	
		<br>
		<a href="new_admin.php">+ Add a new Admin</a>
	
	
</div>

<?php //include("../includes/layouts/footer.php");
ob_end_flush(); ?>