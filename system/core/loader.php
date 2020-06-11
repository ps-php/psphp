<?php
extract($config);
$helpers = $autoload['helper'];
$libs = $autoload['library'];
/*
| Show error when loader can't load the file
*/
function loader_errors($type, $name){
	require SYSPATH.'/errors/loader_errors.php'; die;
}
/*
| Helpers Loader
*/
function sys_load_helpers($helpers){
	foreach($helpers as $helper){
		if(is_file($file = BASEPATH."/system/helpers/$helper.php")){
			require $file;
		}else if(is_file($file = $file = BASEPATH."/application/helpers/$helper.php")){
			require $file;
		}else{
			loader_errors('helper', $helper);
		}
	}
}
/*
| Libraries Loader
*/
function sys_load_library($libraries){
	foreach($libraries as $library){
		if(is_file($file = BASEPATH."/system/libraries/$library.php")){
			require $file;
		}else if(is_file($file = $file = BASEPATH."/application/libraries/$library.php")){
			require $file;
		}else{
			loader_errors('library', $library);
		}
	}
}
/*
| Composer packages loader
*/
if($composer_autoload) require BASEPATH."/vendor/autoload.php";
/*
| Load helpers file if exists
*/
if(!empty($helpers)) sys_load_helpers($helpers);
/*
| Load libraries file if exists
*/
if(!empty($libs)) sys_load_library($libraries);
