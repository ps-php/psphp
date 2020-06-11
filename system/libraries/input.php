<?php
/*
| Input through GET method
*/
function input_get($name, $sanitize = false){
	if(!isset($_GET[$name])) return false;
	if($sanitize){
		$result = trim(htmlspecialchars(strip_tags($_GET[$name])));
	}else{
		$result = trim($_GET[$name]);
	}
	return $result;
}
/*
| Input through POST method
*/
function input_post($name, $sanitize = false){
	if(!isset($_POST[$name])) return false;
	if($sanitize){
		$result = trim(htmlspecialchars(strip_tags($_POST[$name])));
	}else{
		$result = trim($_POST[$name]);
	}
	return $result;
}
