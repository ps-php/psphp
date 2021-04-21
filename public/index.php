<?php
session_start();
$dir = dirname(__FILE__);

define('BASEPATH', "$dir/..");
define('APPPATH', BASEPATH . '/app');
define('SYSPATH', BASEPATH . '/system');
define('FCPATH', $dir);

$app = require SYSPATH . '/bootstrap.php';

_display__errors();

try {
	_router($app['routes'], $app['config'], $app['middlewares']);
} catch(Exception $e) {
	if(environment() == 'production') show_whoops();
	ob_clean();
	require SYSPATH . '/errors/expected.php';
	die;
} catch(Throwable $t) {
	if(environment() == 'production') show_whoops();
	ob_clean();
	require SYSPATH . '/errors/unexpected.php';
	die;
}
