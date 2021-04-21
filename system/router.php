<?php

require SYSPATH . '/support/route.php';

function _router(array $routes, array $config, array $middlewares) {
	foreach($middlewares['before'] as $middleware) {
		_load__middleware($middleware);
	}
	
	$autoRoute = $config['auto_route'] ?? false;
	$uriPaths = $_SERVER['PATH_INFO'] ?? '/';
	$routes = _route__parser($routes);
	$isLoaded = false;
	
	foreach($routes as $key => $route) {
		if(preg_match("#^$key$#", $uriPaths, $match)) {
			if(!_route__isMethod($route['method'])) show_404();
			$params = _route__parseParams($route, $match);
			$isLoaded = true;
			
			_run__autoload();
			_load__controller($route['controller']);
			_route__checkAction($action);
			
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
			
			_load__controller($controller);
			_route__checkAction($action);
			
			call_user_func_array($action, $params);
		} else {
			_load__controller($controller);
			_route__checkAction($action);
			
			call_user_func_array($action, $params);
		}
	} else {
		show_404();
	}
	
	foreach($middlewares['after'] as $middleware) {
		_load__middleware($middleware);
	}
}
