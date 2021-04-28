<?php

require SYSPATH . '/support/validation.php';

function _validation__parse(string $rules) {
	$rules = explode('|', $rules);
	$parsed = [];
	$i = 0;

	if(is_string($rules) && strlen($rules) < 1)
		throw new ErrorException('Validation: You didn\'t set the rules');
	
	foreach($rules as $rule) {
		if(preg_match('/\[(.*?)\]/', $rule, $args)) {
			$parsed[strtok($rules[$i], '[')] = $args[1];
		} else {
			$parsed[$rules[$i]] = null;
		}

		$i++;
	}

	return $parsed;
}

function _validation__validate(array $validation) {
	$errors = [];

	foreach($validation as $name => $item) {
		$label = $name;
		$error = false;

		if(is_array($item)) {
			$rules = _validation__parse($item['rules'] ?? '');
			$label = $item['label'] ?? '';
		} else {
			$rules = _validation__parse($item);
		}

		foreach($rules as $rule => $args) {
			$callName = '_validation_rule_' . $rule;
			
			if(!is_callable($callName)) {
				throw new ErrorException("Validation: rule $rule is not available");
			}

			if($error) continue;
			$error = !$callName($name, $label, $args);
		}

		$errors[] = $error;
	}

	return !in_array(true, $errors);
}

function _validation__runFile(string $name) {
	if(file_exists($path = APPPATH . '/config/validation.php')){
		$validation = require $path;
		
		if(!array_key_exists($name, $validation)) {
			throw new ErrorException("Validation $name doesn't exist");
		}

		return _validation__validate($validation[$name]);
	} else {
		throw new ErrorException('Unable to load the validation');
	}
}

function validation__error($name) {
	return ($_SESSION['validation'][$name]) ?? null;
}

function validation__errors() {
	return $_SESSION['validation'] ?? null;
}

function validation__run($data) {
	$type = gettype($data);

	switch($type) {
		case 'string':
			return _validation__runFile($data);
		break;
		case 'array':
			return _validation__validate($data);
		break;
		default:
			throw new ErrorException('Unable to handle the validation');
		break;
	}
}
