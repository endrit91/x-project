<?php
ob_start();
require_once("../includes/sessions.php");
require_once("../includes/functions.php");
//confirm_logged_in_admin(); // shikojme neseadmini eshte loguar me pare tek login.php dhe edhe ruajtur id e tij tesessioni ktu
$layout_context= "admin"; 
include("../includes/layouts/header.php");

?>
<div id="main">
	<div id="navigation">
		&nbsp;
		
		</div>

		<div id="page">
		<h2> Admin Menu </h2>
		<p>Welcome <?php echo ucfirst(htmlentities($_SESSION["username"])); ?>.</p>	
		<ul>
		<li><a href="index.php">Manage Website Content</a></li>
		<li><a href="manage_admins.php">Manage Admin Users </a></li>
		<li><a href="logout.php">Logout</a></li>
		</ul>	
	</div>
	
<?php //include("../includes/layouts/footer.php");
ob_end_flush();	 ?>