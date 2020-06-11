<?php
function base_url($url = null){
	global $base_url;
	return $base_url.$url;
}
function uri($segment = null){
	$url = $_SERVER['PATH_INFO'];
	$url = explode('/', substr($url, 1));
	if(!is_null($segment)){
		return isset($url[$segment]) ? $url[$segment] : null;
	}else{
		return $url;
	}
}
function redirect($path){
	global $base_url;
	$url = $base_url.$path;
	header("Location: $url");
	exit();
}
