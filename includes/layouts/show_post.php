<?php
if(isset($_SESSION['user_id']) && ($layout_context !== "index_public")){ // we do this in order to have acces to index.php behave public
  $user_id = $_SESSION['user_id'];
  $result= find_posts_by_user_id($user_id); 

  $num_results= mysqli_num_rows($result);
        //echo "<h4 class=\"\">Number of posts: ".$num_results."</h4>";
  ?>
  <a href="new_post.php"><button id="add_new_post_btn" class="btn btn-success">+ Add new post</button></a>
  <?php
} else{

  $result= find_posts(); 

  $num_results= mysqli_num_rows($result);

}
?>
<div><!--beging ofcarousel div -->
  <?php    
  for ($i=0; $i < $num_results; $i++) {
    $row = mysqli_fetch_assoc($result);
    echo "<h4 class=\"\">".ucfirst($row["username"])."</h4>";
    echo "<p class=\"\">".nl2br($row["description"])."</p>"."<h6 class=\"time_of_post\">".htmlentities($row["time_created"])."</h6>";
//echo "<p class=\"\">".$row["file_names"]."</p><br>";
    
    $file_names = explode(", ", $row["file_names"]);
    $nr_of_photos = count($file_names);


    ?>
    <div class= "container"> 
      <br>

      <div id="myCarousel<?php echo $i;?>" class="carousel slide" data-ride="carousel"> <!-- start of the carousel div-->
        <ol class="carousel-indicators">

          <li data-target="#myCarousel<?php echo $i;?>" data-slide-to="0" class="active"></li>
          <?php  

          for ($j=1; $j < $nr_of_photos; $j++) {

            ?>   <!-- Indicators -->

            <li data-target="#myCarousel<?php echo $i;?>" data-slide-to="<?php echo $j; ?>"></li>  
            <?php
          }
          ?>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="thumbnail item active">
            <a href="uploads/<?php echo htmlentities($file_names[0]); ?>" target="_blank">
              <img src="uploads/<?php echo htmlentities($file_names[0]); ?>" alt="" width="360" height="245"></a>
            </div>
            <?php

            for ($z=1; $z < $nr_of_photos; $z++){
              ?>
              <div class="thumbnail item">
                <a href="uploads/<?php echo htmlentities($file_names["$z"]); ?>" target="_blank">
                  <img src="uploads/<?php echo htmlentities($file_names["$z"]); ?>" alt="" width="360" height="245"></a>
                </div>
                <?php
              }
              ?>
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel<?php echo $i;?>" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel<?php echo $i;?>" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
        <?php if(isset($_SESSION['user_id']) && $layout_context !== "index_public"){ ?>
        <a href="edit_post.php?post_id=<?php echo $row["id"]; ?>"><button id="edit_post_btn" class="btn btn-default">Edit post</button></a>
        <a href="delete_post.php?post_id=<?php echo $row["id"]; ?>"><button id="delete_post_btn" class="btn btn-danger btn-sm">Delete post</button></a>
        <?php } elseif (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] == 1)) {
          ?><a href="delete_post.php?post_id=<?php echo $row["id"]; ?>"><button id="delete_post_btn" class="btn btn-danger btn-sm">Delete post</button></a>
          <?php } ?>

          <hr class="line"/>
          <?php 

        } 
        mysqli_free_result($result);         
        ?>
    </div> <!-- end of the carousel div-->