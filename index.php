<?php
$dir = dirname(__FILE__);

define('BASEPATH', $dir);
define('APPPATH', $dir.'/application');
define('SYSPATH', $dir.'/system');

require BASEPATH.'/system/core/bootstrap.php';

if(isset($_SESSION['fv'])){
	unset($_SESSION['fv']);
}
/*
| Unsetting flashdata session if exists
*/
if(isset($_SESSION['flashdata'])){
	unset($_SESSION['flashdata']);
}
