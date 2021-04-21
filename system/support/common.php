<?php

function config(string $name = null) {
	global $config;
	
	if(!is_null($name)) return $config[$name] ?? null;
	return $config;
}

function show_404() {
	header("HTTP/1.0 404 Not Found");
	require APPPATH . '/views/errors/404.php';
	die;
}

function view(string $view, array $params = []) {
	extract($params);
	if(file_exists($path = APPPATH . "/views/$view.php")) {
		require $path;
	} else {
		throw new ErrorException("View $view is not found");
	}
}

function helper(string $helper) {
	$suffix = config('helper_suffix');
	
	if(file_exists($path = SYSPATH . "/helpers/$helper.helper.php")) {
		require $path;
	} else if(file_exists($path = APPPATH . "/helpers/$helper" . "$suffix.php")) {
		require $path;
	} else {
		throw new ErrorException("Helper $helper is not found");
	}
}

function library(string $library) {
	if(file_exists($path = SYSPATH . "/libraries/$library.php")) {
		require $path;
	} else if(file_exists($path = APPPATH . "/libraries/$library.php")) {
		require $path;
	} else {
		throw new ErrorException("Helper $library is not found");
	}
}

function _load__controller(string $controller) {
	if(file_exists($path = APPPATH . "/controllers/$controller.php")) {
		require $path;
	} else {
		throw new ErrorException("Controller $controller is not found");
	}
}

function _run__autoload() {
	require APPPATH . '/config/autoload.php';
	
	foreach($autoload['libraries'] as $library) {
		library($library);
	}
	
	foreach($autoload['helpers'] as $helper) {
		helper($helper);
	}
}