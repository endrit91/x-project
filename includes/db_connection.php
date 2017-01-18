<?php
define("DB_SERVER", "192.163.215.16"); 
define("DB_USER", "endritgj_endrit");
define("DB_PASS", "91albania91");
define("DB_NAME", "endritgj_x-project");

$connection= mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
           
// 1.2. test if connected

if(mysqli_connect_errno()) {
	die ("Database connection failed:". "-".
		mysqli_connect_error(). "-".
		mysqli_connect_errno() );
}
?>