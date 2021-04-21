<?php
function base_url($url = ''){
	return config('base_url').$url;
}

function uri_segment(int $segment = null){
	$url = $_SERVER['PATH_INFO'];
	$url = explode('/', substr($url, 1));
	
	return $url[$segment] ?? null;
}

function redirect(string $path){
	$baseUrl = config('base_url');
	$url = $baseUrl.$path;
	header("Location: $url");
	exit();
}
