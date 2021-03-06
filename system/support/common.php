<?php

function _env(string $name) {
	if(file_exists($path = BASEPATH . '/env.php')) {
		$env = require $path;
		return $env[strtoupper($name)] ?? null;
	}
	
	return null;
}

function config(string $name = null) {
	global $config;
	
	if(!is_null($name)) return _env($name) ?? $config[$name] ?? null;
	return $config;
}

function environment() {
	$supported = ['development', 'production'];
	$env = strtolower(config('app_environment') ?? 'production');
	
	return (in_array($env, $supported)) ? $env : 'production';
}

function show_404() {
	header("HTTP/1.0 404 Not Found");
	if(file_exists($path = APPPATH . '/views/errors/404.php')) {
		require $path;
	} else {
		require SYSPATH . '/errors/404.php';
	}
	die;
}

function show_whoops() {
	header("HTTP/1.0 500 Internal Server Error");
	if(file_exists($path = APPPATH . '/views/errors/whoops.php')) {
		require $path;
	} else {
		require SYSPATH . '/errors/whoops.php';
	}
	die;
}

function show_419() {
	header("HTTP/1.0 419 Expired");
	if(file_exists($path = APPPATH . '/views/errors/419.php')) {
		require $path;
	} else {
		require SYSPATH . '/errors/419.php';
	}
	die;
}

function show_403() {
	header("HTTP/1.0 403 Forbidden");
	if(file_exists($path = APPPATH . '/views/errors/403.php')) {
		require $path;
	} else {
		require SYSPATH . '/errors/403.php';
	}
	die;
}

function model(string $model) {
	if(file_exists($path = APPPATH . "/models/$model.php")) {
		require $path;
	} else {
		throw new Exception("Model $model is not found");
	}
}

function view(string $view, array $params = []) {
	$GLOBALS['psview-data'] = $params;
	extract($params);

	if(file_exists($path = APPPATH . "/views/$view.php")) {
		require SYSPATH . '/support/view.php';
		require $path;

		if($content = $GLOBALS['view']['extend'] ?? false) {
			ob_get_clean();
			$content = _view__cleanContent($content);
			unset($GLOBALS['view']);

			echo $content;
		}

		unset($GLOBALS['psview-data']);
	} else {
		throw new Exception("View $view is not found");
	}
}

function helper(string $helper) {
	$suffix = config('helper_suffix');
	
	if(file_exists($path = SYSPATH . "/helpers/$helper.helper.php")) {
		require $path;
	} else if(file_exists($path = APPPATH . "/helpers/$helper" . "$suffix.php")) {
		require $path;
	} else {
		throw new Exception("Helper $helper is not found");
	}
}

function library(string $library) {
	if(file_exists($path = SYSPATH . "/libraries/$library.php")) {
		require $path;
	} else if(file_exists($path = APPPATH . "/libraries/$library.php")) {
		require $path;
	} else {
		throw new Exception("Library $library is not found");
	}
}

function _load__controller(string $controller) {
	if(file_exists($path = APPPATH . "/controllers/$controller.php")) {
		require $path;
	} else {
		if(environment() != 'production') throw new Exception("Controller $controller is not found");
		show_404();
	}
}

function _load__middleware(string $middleware) {
	if(file_exists($path = APPPATH . "/middleware/$middleware.php")) {
		require $path;
	} else {
		throw new Exception("Middleware $middleware doesn't exist");
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

function _display__errors() {
	error_reporting(-1);
	ini_set('display_errors', 1);
}
