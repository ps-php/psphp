<?php

function _router(array $routes, array $config, array $middlewares) {
	foreach($middlewares['before'] as $middleware) {
		_load__middleware($middleware);
	}

	$autoRoute = $config['auto_route'] ?? false;
	$uriPaths = $_SERVER['PATH_INFO'] ?? '/';
	$isLoaded = false;
	
	foreach($routes as $route) {
		$pattern = $route['pattern'];

		if(preg_match("#^$pattern$#", $uriPaths, $match)) {
			if(!_route__isMethod($route['method'])) continue;
			$params = _route__parseParams($route, $match);
			$isLoaded = true;
			
			_run__autoload();
			_load__controller($route['controller']);
			_route__checkAction($route['action']);
			
			call_user_func_array($route['action'], $params);
		}
	}
	
	if($autoRoute && !$isLoaded) {
		$controller = $config['default_controller'];
		$action = 'index';
		$params = [];
		$exp = explode('/', rtrim($uriPaths, '/'));
		array_shift($exp);
		_run__autoload();
		
		if(count($exp) > 0) {
			$controller = $exp[0];
			if(count($exp) > 1) $action = $exp[1];
			if(count($exp) > 2) $params = array_slice($exp, 2);
		}

		_load__controller($controller);
		_route__checkAction($action);
		call_user_func_array($action, $params);

	} else {
		if(!$isLoaded) show_404();
	}
	
	foreach($middlewares['after'] as $middleware) {
		_load__middleware($middleware);
	}
}
