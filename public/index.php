<?php
$dir = dirname(__FILE__);

define('BASEPATH', "$dir/..");
define('APPPATH', BASEPATH . '/app');
define('SYSPATH', BASEPATH . '/system');
define('FCPATH', $dir);

$app = require SYSPATH . '/bootstrap.php';

_display__errors();

try {
	_router($app['routes'], $app['config']);
} catch(Exception $e) {
	if(environment() == 'production') show_whoops();
	require SYSPATH . '/errors/expected.php';
	die;
} catch(Throwable $t) {
	if(environment() == 'production') show_whoops();
	require SYSPATH . '/errors/unexpected.php';
	die;
}

if(isset($_SESSION['fv'])){
	unset($_SESSION['fv']);
}
/*
| Unsetting flashdata session if exists
*/
if(isset($_SESSION['flashdata'])){
	unset($_SESSION['flashdata']);
}
