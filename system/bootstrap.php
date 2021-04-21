<?php
require APPPATH . '/config/config.php';
require APPPATH . '/config/routes.php';
require SYSPATH . '/support/common.php';

$app = [
	'config' => $config,
	'routes' => $routes
];

require SYSPATH . '/router.php';

return $app;
