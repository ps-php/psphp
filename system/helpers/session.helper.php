<?php
/*
| Setting flashdata session
*/
function session__setFlashdata($name, $data){
	$_SESSION['flashdata'] = [
		$name => $data
	];
}
/*
| Getting flashdata value
*/
function session__flashdata($name){
	return $_SESSION['flashdata'][$name] ?? null;
}
/*
| Stetting userdata session
*/
function session___setUserdata($data){
	foreach($data as $name => $value){
		$_SESSION['userdata'][$name] = $value;
	}
}
/*
| Getting userdata value
*/
function session__userdata($name = null){
	if(isset($_SESSION['userdata'][$name])){
		return $_SESSION['userdata']['username'];
	}else{
		return false;
	}
}
/*
| Unsetting userdata session
*/
function session__unsetUserdata($name){
	unset($_SESSION['userdata'][$name]);
}
