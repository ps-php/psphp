<?php
/*
| Setting flashdata session
*/
function session_set_flashdata($name, $data){
	$_SESSION['flashdata'][$name] = $data;
}
/*
| Getting flashdata value
*/
function session_flashdata($name){
	return (isset($_SESSION['flashdata'][$name])) ? $_SESSION['flashdata'][$name] : false;
}
/*
| Stetting userdata session
*/
function session_set_userdata($data){
	foreach($data as $name => $value){
		$_SESSION['userdata'][$name] = $value;
	}
}
/*
| Getting userdata value
*/
function session_userdata($name = null){
	if(isset($_SESSION['userdata'][$name])){
		return $_SESSION['userdata']['username'];
	}else{
		return false;
	}
}
/*
| Unsetting userdata session
*/
function session_unset_userdata($name){
	unset($_SESSION['userdata'][$name]);
}