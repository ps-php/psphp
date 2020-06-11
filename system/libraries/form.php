<?php
/*
| Because problem in the global variables
| We use class solution
*/
class ConfigForm{
	public static $run = [];
	public static function set_run($param){
		array_push(self::$run, $param);
	}
}
$_SESSION['fv']= ['errors' => []];
/*
| Pushing errors session
*/
function fv_push_error($error){
	$sess = $_SESSION['fv']['errors'];
	$merged = array_merge($sess, $error);
	$_SESSION['fv']['errors'] = $merged;
}
/*
| Required rule function
*/
function fv_validate_required($name, $initial, $msg){
	$res = isset($_POST[$name]) ? strlen($_POST[$name]) : 0;
	if($res > 0){
		ConfigForm::set_run('true');
		return true;
	}else{
		ConfigForm::set_run('false');
		if(!$msg) $msg = "field is required";
		$error = [$name => "{$initial} $msg"];
		fv_push_error($error);
	}
}
/*
| Min Length rule function
*/
function fv_validate_min_length($min, $name, $initial, $msg){
	$res = isset($_POST[$name]) ? strlen($_POST[$name]) : 0;
	if($res < strval($min)){
		ConfigForm::set_run('false');
		if(!$msg) $msg = "field minimum $min Character";
		$error = [$name => "{$initial} $msg"];
		fv_push_error($error);
	}else{
		ConfigForm::set_run('true');
		return true;
	}
}
/*
| Set rules function
*/
function fv_set_rules($name, $initial, $rules, $msg = false){
	if(empty($_POST)) return;
	$rules = explode('|', $rules);
	foreach ($rules as $rule) {
		if (preg_match('/\[(.*?)\]/', $rule, $args) == 1){
			$func = 'fv_validate_'.strtok($rule, '[');
			$res = $func($args[1], $name, $initial, $msg);
			if(!$res) break;
		}else{
			$func = 'fv_validate_'.$rule;
			$res = $func($name, $initial, $msg);
			if(!$res) break;
		}
	}
}
/*
| Check if validation run or not
*/
function fv_run(){
	$results = ConfigForm::$run;
	if(empty($results)) return false;
	return in_array('false', $results) ? false : true;
}
/*
| Echo form error
*/
function form_error($name){
	$err = isset($_SESSION['fv']['errors'][$name]) ? $_SESSION['fv']['errors'][$name] : '';
	return $err;
}
/*
| Return post value
*/
function form_value($name){
	return (isset($_POST[$name])) ? $_POST[$name] : null;
}