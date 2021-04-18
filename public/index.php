<?php
$dir = dirname(__FILE__);

define('BASEPATH', "$dir/../");
define('APPPATH', BASEPATH . 'application/');
define('SYSPATH', BASEPATH . 'system/');

require SYSPATH . 'core/bootstrap.php';

if(isset($_SESSION['fv'])){
	unset($_SESSION['fv']);
}
/*
| Unsetting flashdata session if exists
*/
if(isset($_SESSION['flashdata'])){
	unset($_SESSION['flashdata']);
}
