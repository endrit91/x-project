<?php
 ob_start();
  require_once("../includes/sessions.php"); 
  require_once("../includes/db_connection.php"); 
  require_once("../includes/functions.php"); 
  require_once("../includes/validation_functions.php");
  $layout_context = "index_public"; 

  include("../includes/layouts/header_public.php"); // here is the begining of the page, like opening body tags and htlm, and navigation 
  ?>

  <div class="container content_container" id="top_container"> 


    <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-center" id="posts_top">
      <?php
      
      ?>

      <?php include("../includes/layouts/show_post.php"); ?> <!-- here we have the carousel-->
    </div>

  </div> <!-- end of first page container, begining is in header_public.php-->
  <div class="">   
   <div class="row">
    <div id="results" class="col-md-12">

    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-8" id="">
    </div>
    <div class="col-md-2">
    </div>
  </div>

</div>
</div>
<?php include("../includes/layouts/footer_public.php"); // here are also the closing tags ofbody and html 
ob_end_flush(); ?> 
