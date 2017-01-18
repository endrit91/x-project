//$( document ).ready(function() {
  //  console.log( "ready!" );

    //$("#search_form").submit(function( event ) {
	//	  var searchterm = $( "input[name='searchterm']" ).val();
	//	  console.log(searchterm);
	//	  var url = "http://localhost/Library/public/index.php?searchtype=author&searchterm=" + searchterm + "&submit=Search";
	//	  console.log(url);

	//	  $( "#results" ).load( url + " #search_result" );

	//	  event.preventDefault();
	//});
//});
//$('#menu').on('click', function(){
  //  $('#menu').removeClass('selected');
    //$(this).addClass('selected');
     //event.preventDefault();
    
//});
$(document).ready(function(){
    $('a').click(function(){
        $('a').removeClass("active");
        $(this).addClass("active");
    });
  });
//...........................................
  /*  function inactivityTime() {
    var t;
    window.onload = resetTimer;
    // DOM Events
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onscroll = resetTimer;

    function logout() {
       // alert("Your session terminated, please login.")
        //window.location = 'logout.php';
    }

    function resetTimer() {
        clearTimeout(t);
        t = setTimeout(logout, 10000)
        // 1000 milisec = 1 sec
    }
};
    
 */


