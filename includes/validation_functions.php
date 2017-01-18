<?php


$errors = array();  // e deklarojme si array
//................


function field_name_as_text($field_name){
$field_name= str_replace("_"," ",$field_name);
$field_name= ucfirst($field_name);
return $field_name;
}

//..............................



function has_presence($value) {

return isset($value) && $value !=="";

}
//..................................

function validate_presences($required_fields){
	global $errors;
	foreach($required_fields as $field){
		$value= trim($_POST[$field]);
		if(!has_presence($value)){
			$errors[$field]= field_name_as_text($field). " can't ne blank";
		}
	}
}

//.............................
function validate_email($email){
	global $errors;
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   $errors[]= "Please provide a valid email";
}
}
///..........................

function has_max_length($value, $max) {
return strlen($value)<= $max; 
}

function has_min_length($value, $min) {
return strlen($value)>= $min; 
}
//................................
function inclusion_set($value, $set) {


return in_array($value, $set);
	
}
////////...........
function validate_max_lengths($fields_with_max_lengths) {
	global $errors;

foreach($fields_with_max_lengths as $field=>$max){
	$value=trim($_POST[$field]);
	if(!has_max_length($value,$max)){
		$errors[$field]=field_name_as_text($field). " is too long";
	}
}	
}

//.....................

function validate_min_lengths($fields_with_min_lengths) {
	global $errors;

foreach($fields_with_min_lengths as $field=>$min){
	$value=trim($_POST[$field]);
	if(!has_min_length($value,$min)){
		$errors[$field]=field_name_as_text($field). " should be at least 5 characters ";
	}
}	
}
//....................................................................





?>		

