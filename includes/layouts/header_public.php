<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>X-Project</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
  <link rel="stylesheet" type="text/css" href="css/public.css" media="all">
  <link rel="stylesheet" type="text/css"  href="css/dropzone.css" />
  
</head>
<body>

  <nav id= "horizontal_navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>         
        </button>
        <a  href="index.php" class= "navbar-brand">X-Project</a>
      </div>

      <div class="collapse navbar-collapse">
        <ul class= "nav navbar-nav">
          <li class=""><a href="index.php#top_container">Home</a></li>
           <?php if (isset($_SESSION['user_id'])) { ?>
          <li><a href="users_post.php#top_container">Posts</a></li>
          <li><a href="users_post.php#gallery">Gallery</a></li>
          <?php if(isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] == 1)) { ?>
          <li><a href="admin.php#main">Admin Panel</a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php if (!isset($_SESSION['user_id'])) { ?>
        <div class="btn-group navbar-right">
        <a href="new_user.php"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-user btn-info"></span> Sign Up
          </button></a>
          <a href="login.php"><button type="button" class="btn btn-default" ><span class="glyphicon glyphicon-log-in"></span> Log In
          </button></a>
        </div>
        <?php
      }else{
        ?>
        <div class="btn-group navbar-right">
        <!--  <a href="user_account.php"><button type="button" class="btn btn-info btn-sm my_account_button">
            <span class="glyphicon glyphicon-user"></span> My Account 
          </button></a> -->
          <a href="logout.php"><button type="button" class="btn btn-default btn-sm  log_button">
            <span class="glyphicon glyphicon-log-out"></span> Log out </button></a> 
          </div>

          <?php
        }
        ?>
      </div>
    </nav>

