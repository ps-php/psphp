<?php
$paths = @explode('/',$_SERVER['PATH_INFO']);
unset($paths[0]);
/*
| Load the controller if exist
*/
if(!empty($paths[1])){
	if(!isset($paths[2])) $paths[2] = null;
	if(!isset($paths[3])) $paths[3] = null;
	$controller = BASEPATH."/application/controllers/$paths[1].php";
	if(file_exists($controller)){
		controllers_load($controller, $paths[2], $paths[3]);
	}else{
		show_404();
	}
}else{
	$controller = BASEPATH.'/application/controllers/'.$default_controller.'.php';
	controllers_load($controller);
}
