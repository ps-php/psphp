<?php

function _load__controller(string $controller) {
	if(file_exists($path = APPPATH . "/controllers/$controller.php")) {
		require $path;
	} else {
		throw new ErrorException("Controller $controller is not found");
	}
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
