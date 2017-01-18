<?php ob_start();
function redirect_to($new_page){
	header("Location:". $new_page);
	exit;
}
//.................................................

function mysql_escape($string){
	global $connection;
	$escaped_string=mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}



//...................................................................
function confirm_query($result_set){
	if(!$result_set) {
		die("Database query failed.");
	}
}
//...................................................
function form_errors($errors=array()){
	$output= "";
	if (!empty($errors)) {
		$output="<div class=\"error\">";
		$output.= "Please fix the following errors:";

		$output.= "<ul>";

		foreach ($errors as $key => $error) {

			$output .= "<li>";
			$output .=htmlentities($error);
			$output .="</li>";
		}
		$output .= "</ul>";
		$output .= "</div>";
	}
	return $output;
}
//.....................................
// 2. Perform database QUERY
function query_menu_results($public=true){ // po ndertojme contxtion per publicvs admin
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$query = "SELECT * ";
	$query.= "FROM menu ";
	if ($public){
		$query.= "WHERE visible=1 ";
	}
  // sepse jemi te paneli i adminit, duhet ti shohim te gjitha
	$query.= "ORDER BY position ASC ";

	$menu_result= mysqli_query($connection, $query);

confirm_query($menu_result);            // eshte te funksionet, tregon a ka deshtuar query
return $menu_result;
}

//...................................................
function query_pages_for_menu($menu_id, $public=true){
// 2. Perform database QUERY
	global $connection;   
	$query = "SELECT * ";  
          // jemi akoma brenda while loop, nese do ishim jashte nuk do njihej variabli $menu['id']
	$query.= "FROM pages ";
//
//
	$query.= "WHERE menu_id= {$menu_id} ";
	if ($public){
		$query.= "AND visible=1 ";	
	}
// ketu i japimnje vlere fiktive ne menyre qe te mos jete array sepse eshte ne scope, ndersa te funksioni ijapim vleren e duhur
	$query.= "ORDER BY position ASC";

	$result_page= mysqli_query($connection, $query);

	confirm_query($result_page);

	return $result_page;
}

//...............................................

function navigation($menu_array,$page_array){    // duhet pare kjo false
	// navigimi merr 2 argumente qe jane pjese e loop
	// keto argumente jane fiktive, prandaj i ndyshojme edhe me poshte, mund te vendosnim edhe global po eshte me mire keshtu, ndersa tek deklarimi i funksionit e vendosim me argumentin e duhur

	$output="<ul class=\"menu\">";

	$menu_result=query_menu_results(false);

// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
	while($menu= mysqli_fetch_assoc($menu_result)) {
	// output data from each row

		$output.= "<li class=\"button\"";
		if ($menu_array && $menu["id"]==$menu_array["id"]) {
			$output.= " class=\"selected\"";
		}
		$output.= ">";

		$output.="<a href=\"manage_content.php?menu=";
		$output.= urlencode($menu["id"]); 
		$output.="\">";
		$output.= htmlentities($menu["menu_name"]); 
		$output.="</a>";

//......fillon pages-------------------------------

$result_page=query_pages_for_menu($menu["id"],false); // query i dyte
$output.="<ul class=\"pages\">";

while($pages= mysqli_fetch_assoc($result_page)) {
	// loop per pages
	
	$output.= "<li";
	if ($page_array && $pages["id"]==$page_array["id"]) {
		$output.= " class=\"selected\"";
	}
	$output.= ">";
	
	$output.="<a href=\"manage_content.php?pages=";
	$output.= urlencode($pages["id"]); 
	$output.="\">";
	$output.= htmlentities($pages["page_name"]); 
	$output.="</a></li>";
	
}
mysqli_free_result($result_page);


$output.="</ul>";
$output.="</li>";


}
mysqli_free_result($menu_result);

$output.="</ul>";
return $output;

}

//..........................................................................................................................
function show_pages_by_menu($menu_array,$page_array){ // 

//......fillon pages-------------------------------

	if ($menu_array){
$result_page=query_pages_for_menu($menu_array["id"],false); // query i dyte// duhet pare kjo false qe kam bere
$output="<ul class=\"pages\">";

while($pages= mysqli_fetch_assoc($result_page)) {

	// loop per pages
	
	$output.= "<li>";
	
	$output.="<a href=\"manage_content.php?pages=";
	$output.= urlencode($pages["id"]); 
	$output.="\">";
	$output.= htmlentities($pages["page_name"]); 
	$output.="</a></li>";
	
}
mysqli_free_result($result_page);
$output.="</ul>";
}

return $output;
}

//.................................................

function show_pages_by_menu_query($menu_array,$page_array){ // 

	if ($menu_array){
		$result_page=query_pages_for_menu($menu_array["id"],false);
		return $result_page;
	}
}

//''''''''''''''''''''''''''''''''''''''''''''''''

function find_menu_by_id($menu_id,$public=true){  // kujdes
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_menu_id= mysqli_real_escape_string($connection,$menu_id);
	$query = "SELECT * ";
	$query.= "FROM menu ";
	$query.= "WHERE id={$safe_menu_id} ";
	if ($public) {
		$query .= "AND visible= 1 ";
	}

	$query.= "LIMIT 1";

	$menu_result= mysqli_query($connection, $query);

	confirm_query($menu_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($menu=mysqli_fetch_assoc($menu_result)){// e bejme qe ketu te funksioni asociimin meqe kemi vetem 1 rezultat, per efekt lehtesie
		return $menu; 
	}else{
		$return=null;
	}
}
///.............................................................
function find_invisible_page(){
global $connection; 
$query="SELECT * FROM pages WHERE visible=0 LIMIT 1";
        $result= mysqli_query($connection, $query);

        confirm_query($result);
        if($page= mysqli_fetch_assoc($result)){
        	return $page; 
	}else{
		return null;
	}
	mysqli_free_result($result);
        }


//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
function find_page_by_id($page_id, $public=false){
// 2. Perform database QUERY
	global $connection;
	$safe_page_id= mysqli_real_escape_string($connection,$page_id);

	$query = "SELECT * ";  
          // jemi akoma brenda while loop, nese do ishim jashte nuk do njihej variabli $menu['id']
	$query.= "FROM pages ";
	$query.= "WHERE id= {$safe_page_id} ";
	if ($public) {
		$query .= "AND visible= 1 ";
	}
// ketu i japimnje vlere fiktive ne menyre qe te mos jete array sepse eshte ne scope, ndersa te funksioni ijapim vleren e duhur
	$query.= "LIMIT 1";

	$page_result= mysqli_query($connection, $query);

	confirm_query($page_result);

	if($page=mysqli_fetch_assoc($page_result)){
		return $page;
	} else{
		return null;
	}
}
//...................................................................



/////.................................................................
function find_default_page_for_menu($menu_id){
	$page_result=query_pages_for_menu($menu_id);
	if($first_page=mysqli_fetch_assoc($page_result)){
		return $first_page;
	}else{
		return null;
	}
}


//
//..................................
function find_selected_page($public=false){

	global $current_menu;
	global $current_page;

	if (isset($_GET["menu"])){
		$current_menu=find_menu_by_id($_GET["menu"],$public);
		if($current_menu && $public){
			$current_page=find_default_page_for_menu($current_menu["id"],$public);	// duhet pare kjo $public
		}else{
			$current_page=null;
		}

	} elseif (isset($_GET["pages"])){

		$current_page=find_page_by_id($_GET["pages"],$public);
		$current_menu=null;
} else { //sepse kur vjen nga admin.php nuk eshte e definuar
	$current_menu=null;
	$current_page=null;
}
}
//////.......................................................................


//....................................................................................................................
function public_navigation($menu_array,$page_array){
	// navigimi merr 2 argumente qe jane pjese e loop
	// keto argumente jane fiktive, prandaj i ndyshojme edhe me poshte, mund te vendosnim edhe global po eshte me mire keshtu, ndersa tek deklarimi i funksionit e vendosim me argumentin e duhur

	$output="<ul class=\"menu\" id=\"menu\">";

	$menu_result=query_menu_results();

// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
	while($menu= mysqli_fetch_assoc($menu_result)) {
	// output data from each row

		$output.= "<li";
		if ($menu_array && $menu["id"]==$menu_array["id"]) {
			$output.= " class=\"selected_menu\"";
		}
		$output.= ">";

		$output.="<a "; 
		$output.= " class=\"menu_button\" ";
		$output.= " href=\"index.php?menu=";
		$output.= urlencode($menu["id"]); 

		$output.="\">";
		$output.= htmlentities($menu["menu_name"]); 
		$output.="</a>";

//......fillon pages-------------------------------

if ($menu_array["id"]==$menu["id"] || $page_array["menu_id"]==$menu["id"] ){ // pra nese eshte klikuar nje menu ose faqet e asaj menuse shfaqen dhe vazhdojne te shfaqen faqe

	$result_page=query_pages_for_menu($menu["id"]); // query i dyte
	$output.="<ul class=\"pages\">";

	while($pages= mysqli_fetch_assoc($result_page)) {
		// loop per pages
		
		$output.= "<li";
		if ($page_array && $pages["id"]==$page_array["id"]) {
			$output.= " class=\"selected_page\"";
		}
		$output.= ">";
		$output.="<a "; 
		$output.= " class=\"menu_button\" ";	
		$output.="href=\"index.php?pages=";
		$output.= urlencode($pages["id"]); 
		$output.="\">";
		$output.= htmlentities($pages["page_name"]); 
	$output.="</a></li>"; // fundi i pages

}
	$output.="</ul>"; // fundi i pages
	mysqli_free_result($result_page);
}


$output.="</li>"; // fundi i menuse


}
mysqli_free_result($menu_result);

$output.="</ul>"; // fundi imenuse
return $output;

}

//.........................................................................................................................................
function public_navigation_test($menu_array,$page_array){
	// navigimi merr 2 argumente qe jane pjese e loop
	// keto argumente jane fiktive, prandaj i ndyshojme edhe me poshte, mund te vendosnim edhe global po eshte me mire keshtu, ndersa tek deklarimi i funksionit e vendosim me argumentin e duhur

	$output="<ul class=\"menu\">";

	$menu_result=query_menu_results();

// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
	while($menu= mysqli_fetch_assoc($menu_result)) {
	// output data from each row

		$output.= "<li";
		if ($menu_array && $menu["id"]==$menu_array["id"]) {
			$output.= " class=\"selected_menu\"";
		}
		$output.= ">";

		$output.="<a "; 
		$output.= " class=\"\" ";
		$output.= " href=\"index.php?menu=";
		$output.= urlencode($menu["id"]); 

		$output.="\">";
		$output.= htmlentities($menu["menu_name"]); 
		$output.="</a>";

//......fillon pages-------------------------------

if ($menu_array["id"]==$menu["id"] || $page_array["menu_id"]==$menu["id"] ){ // pra nese eshte klikuar nje menu ose faqet e asaj menuse shfaqen dhe vazhdojne te shfaqen faqe

	$result_page=query_pages_for_menu($menu["id"]); // query i dyte
	$output.="<ul class=\"pages\">";

	while($pages= mysqli_fetch_assoc($result_page)) {
		// loop per pages
		
		$output.= "<li";
		if ($page_array && $pages["id"]==$page_array["id"]) {
			$output.= " class=\"selected\"";
		}
		$output.= ">";
		$output.="<a "; 
		$output.= " class=\"\" ";	
		$output.="href=\"index.php?pages=";
		$output.= urlencode($pages["id"]); 
		$output.="\">";
		$output.= htmlentities($pages["page_name"]); 
	$output.="</a></li>"; // fundi i pages

}
	$output.="</ul>"; // fundi i pages
	mysqli_free_result($result_page);
}


$output.="</li>"; // fundi i menuse


}
mysqli_free_result($menu_result);

$output.="</ul>"; // fundi imenuse
return $output;

}



///.......................................................................................
function query_all_admins(){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$query = "SELECT * ";
	$query.= "FROM users ";
	$query.= "ORDER BY username ASC ";

	$admins_result= mysqli_query($connection, $query);

confirm_query($admins_result);            // eshte te funksionet, tregon a ka deshtuar query
return $admins_result;
}
//...........................................................................


function show_all_admins(){
	$admins_result= query_all_admins();

// 3. Use returned data (if any)

// fetch_assoc  (alternative, slower than row, better)
	while($admins= mysqli_fetch_assoc($admins_result)) {
	// output data from each row
		$output= htmlentities($admins["username"]); 
		$output.= "<br>";
		return $output;
	}
}
//...........................................................

function find_all_books(){
	global $connection;
$query="SELECT books.title, books.price, books.id, books.quantity, 
 group_concat(authors.author separator ', ' ) as author
                  FROM books
                  JOIN authorsbooks on books.id = authorsbooks.book_id
                  JOIN authors on authorsbooks.author_id = authors.id
                  WHERE books.menu_id = 1 
                  GROUP BY books.id
                  ORDER BY books.title ASC
                  ";
                  $result= mysqli_query($connection, $query);
                  confirm_query($result);
                  return $result;
              }


//...............................................................................

function find_all_books_by_category($category_id){
	global $connection;
$query="SELECT books.title, books.price, books.id, books.quantity, 
 group_concat(authors.author separator ', ' ) as author
                  FROM books
                  JOIN authorsbooks on books.id = authorsbooks.book_id
                  JOIN authors on authorsbooks.author_id = authors.id
                  WHERE books.category_id = {$category_id} 
                  GROUP BY books.id
                  ORDER BY books.title ASC
                  ";
                  $result= mysqli_query($connection, $query);
                  confirm_query($result);
                  return $result;
              }






//...................................................................................


function find_admin_by_id($admin_id){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_admin_id= mysqli_real_escape_string($connection,$admin_id);
	$query = "SELECT * ";
	$query.= "FROM users ";
	$query.= "WHERE id={$safe_admin_id} ";
	$query.= "LIMIT 1";

	$admin_result= mysqli_query($connection, $query);

	confirm_query($admin_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($admin=mysqli_fetch_assoc($admin_result)) {
		return $admin; 
	}else{
		return null;
	}
}
//.............................................................................................
function find_user_by_id($user_id){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_user_id= mysqli_real_escape_string($connection,$user_id);
	$query = "SELECT * ";
	$query.= "FROM users ";
	$query.= "WHERE id={$safe_user_id} ";
	$query.= "LIMIT 1";

	$user_result= mysqli_query($connection, $query);

	confirm_query($user_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($user=mysqli_fetch_assoc($user_result)) {
		return $user; 
	}else{
		return null;
	}
}
///.................................................................




//...........................................................................................
function password_encrypt($password){


$hash_format= "$2y$10$"; // 2y do te thote blowfish dhe 10-> sa here perseritetalgoritmi pra 10 here
$salt_length= 22; //Blowfish salt i do 22 karaktereose mme shume
$salt= generate_salt($salt_length);
$format_and_salt = $hash_format . $salt;
$hash= crypt($password, $format_and_salt);

return $hash;
}

///,,,,,,,,,,,,,,,,,,,,,,,,,,,

function generate_salt($length){

	// md5 ka 35 karaktere
	$unique_random_string=md5(uniqid(mt_rand(), true));

	// valid characters for a salt {a-z A-Z 0-9 ./}
	$base64_string= base64_encode($unique_random_string);
	// zevendesojme '+' me '-' per saltin

	$modified_base64_string=str_replace('+', '.', $base64_string);

	// truncate string to the correct length
	$salt=substr($modified_base64_string, 0, $length);
	return $salt;

}

////...,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

function password_check($password, $existing_hash) {
//existing hash ka formatin salt qe ne fillim
	$hash= crypt($password, $existing_hash);
	if ($hash===$existing_hash) {
		return true;
	} else {
		return false;
	}
}
//.....................................................
function find_book_by_id($isbn){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_book_isbn= mysqli_real_escape_string($connection,$isbn);
	$query="SELECT books.title, books.price, books.quantity, books.id, authors.author, books.category
    FROM books
    LEFT JOIN authorsbooks on books.id = authorsbooks.book_id
    LEFT JOIN authors on authorsbooks.author_id = authors.id
    WHERE books.id='{$safe_book_isbn}' 
    
	LIMIT 1";

	$book_result= mysqli_query($connection, $query);

	confirm_query($book_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($book=mysqli_fetch_assoc($book_result)) {
		return $book; 
	}else{
		return null;
	}
}

//................................................................///

function find_author_by_name($author){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_author_name= mysqli_real_escape_string($connection,$author);
	$query = "SELECT * ";
	$query.= "authors ";
	$query.= "WHERE $author='{$safe_author_name}' ";
	$query.= "LIMIT 1";

	$author_result= mysqli_query($connection, $query);

	confirm_query($author_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($author=mysqli_fetch_assoc($author_result)) {
		return $author; 
	}else{
		return null;
	}
}

//...............................................................
function find_user_by_username($username){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_user_username= mysqli_real_escape_string($connection,$username);
	$query = "SELECT * ";
	$query.= "FROM users ";
	$query.= "WHERE username='{$safe_user_username}' ";
	$query.= "LIMIT 1";

	$user_result= mysqli_query($connection, $query);

	confirm_query($user_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($user=mysqli_fetch_assoc($user_result)) {
		return $user; 
	}else{
		return null;
	}
}


///................................................................

function find_user_by_email($email){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$safe_user_email= mysqli_real_escape_string($connection,$email);
	$query = "SELECT * ";
	$query.= "FROM users ";
	$query.= "WHERE email='{$safe_user_email}' ";
	$query.= "LIMIT 1";

	$email_result= mysqli_query($connection, $query);

	confirm_query($email_result);            // eshte te funksionet, tregon a ka deshtuar query
	if($found_user=mysqli_fetch_assoc($email_result)) {
		return $found_user; 
	}else{
		return null;
	}
}

//......................................................................

function attempt_login($username, $password){
	$user= find_user_by_username($username);
	if($user){
		// admin found // now check password
	if(password_check($password, $user["password"])) {//$admin["password vjen nga databaza"]
		// pra nese jane identik
	return $user;
}else{
	//password does not match
	return false;
}

}else{
	return false;
}
}
//..............................................................


///,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
function logged_in_user(){

	return isset($_SESSION['user_id']);
}
// kjo behet per ato faqe qe nuk jane admin por u duhen atribute te vecanta si perdorues, perdoret bashke me funksionin poshte
//................................................

function confirm_logged_in_user() {
	if (!logged_in_user()) {

		redirect_to("login.php");
	} else{

	}
}

function logged_in_admin(){

	return isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function confirm_logged_in_admin(){
	if (!logged_in_admin()) {

		redirect_to("login.php");
	} else{

	}
}

//.................................................

function create_new_post_id(){
	global $connection;  // duke qene se jemi ne scope dhe connection duhet per databazen
	$query = "INSERT INTO posts (post_time) VALUES ('".date("Y-m-d H:i:s")."')";
   //6
  $result = mysqli_query($connection, $query);
confirm_query($result);
	
}
// .....................................................

function find_posts_by_user_id($user_id){
          global $connection;
          $query="SELECT users.username, posts.id, posts.description, posts.visible, posts.time_created, 
          group_concat(uploads.file_name separator ', ' ) as file_names
          FROM users
          JOIN posts on users.id = posts.user_id
          JOIN uploads on posts.id = uploads.post_id
          WHERE users.id = {$user_id} 
          GROUP BY posts.id
          ORDER BY posts.time_created DESC
          ";
          $result= mysqli_query($connection, $query);

          confirm_query($result);
          return $result;
        }

//...................................................

     function  find_posts(){
     	global $connection;
          $query="SELECT users.username, posts.id, posts.description, posts.visible, posts.time_created, 
          group_concat(uploads.file_name separator ', ' ) as file_names
          FROM users
          JOIN posts on users.id = posts.user_id
          JOIN uploads on posts.id = uploads.post_id
          WHERE posts.visible = 1
          GROUP BY posts.id
          ORDER BY posts.time_created DESC
          ";
          $result= mysqli_query($connection, $query);

          confirm_query($result);
          return $result;
     }
//........................................................



//......................................................     

     function find_post_by_id($post_id){
     	global $connection;
$query="SELECT * FROM posts WHERE id= {$post_id}";
$result= mysqli_query($connection, $query);
confirm_query($result);
if($post= mysqli_fetch_assoc($result)) {

		return $post; 
	}else{
		return null;
	}
}
//...........................................................
function find_images_by_user_id($user_id){
          global $connection;
          $query_img = "SELECT *
          FROM uploads
          WHERE uploads.user_id = {$user_id} 
          
          ";
          $result_images= mysqli_query($connection, $query_img);
          confirm_query($result_images);
          return $result_images;
          }


//.......................................................
ob_end_flush(); ?>




