<?php
$dir = dirname(__FILE__);

define('BASEPATH', "$dir/..");
define('APPPATH', BASEPATH . '/app');
define('SYSPATH', BASEPATH . '/system');
define('FCPATH', $dir);

$app = require SYSPATH . '/bootstrap.php';

_router($app['routes'], $app['config']);

if(isset($_SESSION['fv'])){
	unset($_SESSION['fv']);
}
/*
| Unsetting flashdata session if exists
*/
if(isset($_SESSION['flashdata'])){
	unset($_SESSION['flashdata']);
}
