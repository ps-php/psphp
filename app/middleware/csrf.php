<?php

helper('request');

function _csrf__set(bool $regenerate = false) {
	$name = config('csrf_token_name') ?? 'psphp_csrf';
	$expires = time() + intval(config('csrf_token_expires')) ?? 3600;
	if(!isset($_SESSION['csrf']['name'])) {
		$_SESSION['csrf'] = [
			'name' => $name,
			'hash' => base64_encode(openssl_random_pseudo_bytes(32)),
			'expires' => $expires
		];
	} else if($_SESSION['csrf']['name'] != $name || $regenerate) {
		$_SESSION['csrf'] = [
			'name' => $name,
			'hash' => base64_encode(openssl_random_pseudo_bytes(32)),
			'expires' => $expires
		];
	}
}

function csrf_token() {
	return config('csrf_token_name') ?? 'psphp_csrf';
}

function csrf_hash() {
	return $_SESSION['csrf']['hash'] ?? null;
}

function csrf_expires() {
	return $_SESSION['csrf']['expires'] ?? 0;
}

function csrf_field() {
	$name = csrf_token();
	$value = csrf_hash();
	return "
	<input type=\"hidden\" name=\"$name\" value=\"$value\" />
	";
}

_csrf__set();

if(!request__isGet()) {
	$hash = request__post(csrf_token(), true);
	
	if(!array_key_exists(csrf_token(), $_POST)) show_403();
	if($hash != csrf_hash() || time() > csrf_expires()) {
		_csrf__set(true);
		show_419();
	}
	if(config('csrf_regenerate')) _csrf__set(true);
}
