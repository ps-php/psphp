<?php
/*
| Showing 404 if controller not exist
*/
function show_404(){
	header("HTTP/1.0 404 Not Found");
	require BASEPATH.'/application/views/errors/404.php';
}
/*
| Load models in the system dir
*/
function load_helper($helper){
	sys_load_helpers([$helper]);
}
/*
| Load libraries in the system dir
*/
function load_library($library){
	sys_load_library([$library]);
}
/*
| Load views for HTML
*/
function load_view($view, $data = []){
	$view = BASEPATH."/application/views/$view.php";
	if(!file_exists($view)) return show_404();
	if(!empty($data) > 0) extract($data);
	require $view;
}
/*
| Load the model
*/
function load_model($model){
	require BASEPATH."/application/models/$model.php";
}
/*
| Load the controller
*/
function controllers_load($controller, $method = 'index', $value = null){
	if(is_null($method) || strlen($method) < 1) $method = 'index';
	if(strlen($value) < 1) $value = null;
	if(!file_exists($controller)) return show_404();
	require $controller;
	if(function_exists($method)){
		$method($value);
	}else{
		show_404();
	}
}
