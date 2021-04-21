<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class DBConfig{
	static function conn(){
		return mysqli_connect(config('db_host'), config('db_username'), config('db_password'), config('db_name'));
	}
}
/*
| Get all query
*/
function db__getAll($table, $fields = null, $limit = null, $offset = null){
	$db_conn = DBConfig::conn();
	$rows= [];
	$query = "SELECT ";
	$query .= is_null($fields) ? "*" : $fields;
	$query .= " FROM `$table`";
	if(!is_null($limit)) $query .= " LIMIT $limit";
	if(!is_null($offset)) $query .= " OFFSET $offset";
	$result = mysqli_query($db_conn, $query) or trigger_error(mysqli_error($db_conn), E_USER_ERROR);
	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	$totals = mysqli_num_rows($result);
	return ['result' => $rows, 'totals' => $totals];
}
/*
| Select where query
*/
function db__getWhere($table, $data = [], $fields = null, $limit = null, $offset = null){
	$db_conn = DBConfig::conn();
	$rows = [];
	$query = "SELECT ";
	$query .= is_null($fields) ? "*" : $fields;
	$query .=" FROM `$table` WHERE ";
	foreach($data as $field => $value){
		$query .= "`$table`.`$field` = '$value' AND";
	}
	$query = substr($query, 0, -3);
	if(!is_null($limit)) $query .= " LIMIT $limit";
	if(!is_null($offset)) $query .= " OFFSET $offset";
	$result = mysqli_query($db_conn, $query) or trigger_error(mysqli_error($db_conn), E_USER_ERROR);
	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	$totals = mysqli_num_rows($result);
	return ['result' => $rows, 'totals' => $totals];
}
/*
| Like Query
*/
function db__getLike($table, $data = [], $fields = null, $limit = null, $offset = null){
	$db_conn = DBConfig::conn();
	$rows = [];
	$query = "SELECT ";
	$query .= is_null($fields) ? "*" : $fields;
	$query .=" FROM `$table` WHERE ";
	foreach($data as $field => $value){
		$value = mysqli_real_escape_string($db_conn, $value);
		$query .= "`$table`.`$field` LIKE '%$value%' AND";
	}
	$query = substr($query, 0, -3);
	if(!is_null($limit)) $query .= " LIMIT $limit";
	if(!is_null($offset)) $query .= " OFFSET $offset";
	$result = mysqli_query($db_conn, $query) or trigger_error(mysqli_error($db_conn), E_USER_ERROR);
	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	$totals = mysqli_num_rows($result);
	return ['result' => $rows, 'totals' => $totals];
}
/*
| Delete Query
*/
function db__delete($table, $data = []){
	$db_conn = DBConfig::conn();
	$query = "DELETE FROM `$table`";
	if(count($data) > 0){
		$query .= " WHERE";
		foreach($data as $field => $value){
			$query .= " `$table`.`$field`='$value' AND";
		}
		$query = substr($query, 0, -3);
	}
	mysqli_query($db_conn, $query) or trigger_error(mysqli_error($db_conn), E_USER_ERROR);
	return mysqli_affected_rows($db_conn);
}
/*
| Insert query
*/
function db__insert($table, $data){
	$db_conn = DBConfig::conn();
	$fields = "(";
	$values = "VALUES (";
	foreach($data as $field => $value){
		$fields .= "$field,";
		$sanitized = mysqli_real_escape_string($db_conn, $value);
		$values .= "'$sanitized',";
	}
	$fields = substr($fields, 0, -1).")";
	$values = substr($values, 0, -1).")";
	$query = "INSERT INTO `$table`$fields $values";
	mysqli_query($db_conn, $query) or trigger_error(mysqli_error($db_conn), E_USER_ERROR);
	return mysqli_affected_rows($db_conn);
}
/*
| Get table fields list
*/
function db__listFields($table){
	$db_conn = DBConfig::conn();
	$fields = [];
	$query = "SHOW COLUMNS FROM `$table`";
	$result = mysqli_query($db_conn, $query);
	while($field = mysqli_fetch_assoc($result)){
		$fields[] = $field['Field'];
	}
	return $fields;
}
