<div id="footer">@Copyright Endrit Gjeta <?php echo date('Y'); ?></div>
<?php

if (!isset($_COOKIE['remember_me']) && ($layout_context !== "index_public")){ // if the cookie is null we proceed with the cookie login_time to limit the login

	$epoch = $_COOKIE['login_time'];
	$login_time = new DateTime("@$epoch");
	$diff_time= time()- $epoch;
	var_dump($diff_time);

	if ($diff_time > 10){
		$_SESSION["message"] = "Your session terminated, please Login again (check remember me)";
		redirect_to("logout.php");
	} else {
		setcookie('login_time', time());
	}
?>

<?php
} 
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/dropzone.js"></script>
<script>
  $(".content_container").css("min-height", $(window).height());


</script>

	
<?php

// 5.  Close db connection, fromthe footer
if (isset($connection)){   
mysqli_close($connection);
}
?>
	</body>

</html>
