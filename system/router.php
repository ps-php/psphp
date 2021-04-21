<?php

require SYSPATH . '/support/route.php';

function _router(array $routes, array $config) {
	$autoRoute = $config['auto_route'] ?? false;
	$uriPaths = $_SERVER['PATH_INFO'] ?? '/';
	$routes = _route__parser($routes);
	
	foreach($routes as $key => $route) {
		if(preg_match("#^$key$#", $uriPaths, $match)) {
			if(!_route__isMethod($route['method'])) show_404();
			$params = _route__parseParams($route, $match);
			
			_load__controller($route['controller']);
			$loader = call_user_func_array($route['action'], $params);
			
			if(!$loader) throw new ErrorException("Method is not found");
		}
	}
	
	if($autoRoute) {
		$controller = $config['default_controller'];
		$action = 'index';
		$params = [];
		$exp = explode('/', rtrim($uriPaths, '/'));
		array_shift($exp);
		
		if(count($exp) > 0) {
			$controller = $exp[0];
			if(count($exp) > 1) $action = $exp[1];
			if(count($exp) > 2) $params = array_slice($exp, 2);
			
			_load__controller($controller);
			$loader = call_user_func_array($action, $params);
			if(!$loader) throw new ErrorException("Method is not found");
		} else {
			_load__controller($controller);
			$loader = call_user_func_array($action, $params);
			if(!$loader) throw new ErrorException("Method is not found");
		}
	} else {
		show_404();
	}
}
