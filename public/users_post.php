<?php  ob_start();
  require_once("../includes/sessions.php"); 
  require_once("../includes/db_connection.php"); 
  require_once("../includes/functions.php"); 
  require_once("../includes/validation_functions.php");
  $layout_context= "public"; 
  confirm_logged_in_user(); 

  include("../includes/layouts/header_public.php"); // here is the begining of the page, like opening body tags and htlm, and navigation 
  ?>
  <div class="container content_container" id="top_container"> 
    <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-center" id="posts_top">
      <?php
      echo message(); 
      echo form_errors($errors); 
      ?>
      <?php include("../includes/layouts/show_post.php"); ?> <!-- here we have the carousel-->
    </div>
  </div> <!-- end of first page container, begining is in header_public.php-->
  <div class="container content_container center">   
   <div class="row">
    <div id="results" class="col-md-12">

    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-8" id="gallery">
      <?php
      $result_images = find_images_by_user_id($user_id); 
      $img_array = array();
      while($row = mysqli_fetch_assoc($result_images)){
       $img_array[]= $row["file_name"];
     }
     $unique_images_name = array_unique($img_array);
     ?>
     <div class="row" id="gallery_position"> <!-- begining of gallery-->
      <?php
      foreach ($unique_images_name as $image_name) {
        ?>    

        <div class="col-md-4">
          <div class="thumbnail">
            <a href="uploads/<?php echo htmlentities($image_name); ?> " target="_blank">
              <img src="uploads/<?php echo htmlentities($image_name); ?>" class="gallery_img" alt="" style="">
              <div class="caption">
              </div>
            </a>
          </div>
        </div>
        <?php } 
        mysqli_free_result($result_images); 
        ?>
      </div> <!-- end of gallery-->


    </div>
    <div class="col-md-2">
    </div>
  </div>

</div>
</div>
<?php include("../includes/layouts/footer_public.php"); // here are also the closing tags ofbody and html  
ob_end_flush()
?> 