<?php

function _request__sanitize($val) {
	if(is_null($val)) return null;
	$val = trim(htmlspecialchars(strip_tags($val)));
	return $val;
}

function request__isGet() {
	return ($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false;
}

function request__isPost() {
	return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
}

function request__isPut() {
	return ($_SERVER['REQUEST_METHOD'] == 'PUT') ? true : false;
}

function request__isPatch() {
	return ($_SERVER['REQUEST_METHOD'] == 'PATCH') ? true : false;
}

function request__isDelete() {
	return ($_SERVER['REQUEST_METHOD'] == 'DELETE') ? true : false;
}

function request__get(string $name = null, bool $sanitize = false) {
	if(is_null($name)) {
		$parsed = [];
		
		foreach($_GET as $key => $val) {
			$parsed[$key] = _request__sanitize($val);
		}
		return $parsed;
	}
	
	$val = $_GET[$name] ?? null;
	return (!$sanitize) ? trim($val) : _request__sanitize($val);
}

function request__post(string $name = null, bool $sanitize = false) {
	if(is_null($name)) {
		$parsed = [];
		
		foreach($_POST as $key => $val) {
			$parsed[$key] = _request__sanitize($val);
		}
		return $parsed;
	}
	
	$val = $_POST[$name] ?? null;
	return (!$sanitize) ? trim($val) : _request__sanitize($val);
}
