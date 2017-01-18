<?php if (!isset($layout_context)){
	$layout_context= "public"; 
	}
	?>
<!DOCTYPE html>


<head>
<link rel="stylesheet" type="text/css" href="css/private.css" media="all">
	<title>X-Project<?php if ($layout_context== "admin") {echo "Admin";} ?></title>

</head>

<body>
	<div id="header">
		<h1>X-Project <?php if ($layout_context== "admin") {echo "Admin";} ?></h1>
	</div>