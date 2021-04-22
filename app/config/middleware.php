<?php
/*
| This is the global middleware
| which is always run before and after application start
*/
return [
	'before' => [
		'csrf'
	],
	
	'after' => [
		'clearSession'
	]
];
