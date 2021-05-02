<?php

function _route__isMethod(string $method) {
	return ($_SERVER['REQUEST_METHOD'] == $method) ? true : false;
}

function _route__checkAction(string $action) {
	if(!is_callable($action)) {
		if(environment() != 'production') {
			throw new Exception('Controller method doesn\'t exist');
		}
		
		show_404();
	}
	
	return true;
}

function _route__activateRegex(string $route) {
	$replacement = [
		'{}' => '([^/]+)',
		'{' => '(',
		'}' => ')',
		':num' => '[0-9]+',
		':any' => '[^/]+',
		':slug' => '[-a-z0-9]+'
	];
	
	return strtr($route, $replacement);
}

function _route__getVariables(string $route) {
	$regex = "~\{ \s* ([a-zA-Z0-9_]*) \s* (?: : \s* ([^{]+(?:\{.*?\})?) )?\}\??~x";
	
	if(preg_match_all($regex, $route, $matches)) {
		return $matches[1];
	}
	
	return [];
}

function _route__removeVariables(string $routes) {
	$pattern = "/{[a-zA-Z0-9_]+/";
	return preg_replace($pattern, "{" ,$routes);
}

function _route__parseParams(array $route, array $match) {
	$parsed = [];
	$i = 0;
	array_shift($match);
			
	foreach($route['params'] as $var) {
		$parsed[$var] = $match[$i];
		$i++;
	}
	
	return $parsed;
}

function _route__parser(String $route, String $call, array $options) {
	$vars = _route__getVariables($route);
	$pattern = _route__activateRegex(_route__removeVariables($route));
	$exp = explode('@', $call);

	if(isset($options['as'])) {
		return $GLOBALS['routes'][$options['as']] = [
			'pattern' => $pattern,
			'method' => $options['method'],
			'params' => $vars,
			'controller' => $exp[0] ?? null,
			'action' => $exp[1] ?? 'index'
		];
	}

	return $GLOBALS['routes'][] = [
		'pattern' => $pattern,
		'method' => $options['method'],
		'params' => $vars,
		'controller' => $exp[0] ?? null,
		'action' => $exp[1] ?? 'index'
	];
}

function route__get(String $route, String $call, array $options = []) {
	$options['method'] = 'GET';
	return _route__parser($route, $call, $options);
}

function route__post(String $route, String $call, array $options = []) {
	$options['method'] = 'POST';
	return _route__parser($route, $call, $options);
}
