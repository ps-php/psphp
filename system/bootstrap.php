<?php
require APPPATH . '/config/config.php';
require APPPATH . '/config/routes.php';

$app = [
	'config' => $config,
	'routes' => $routes
];

require SYSPATH . '/support/common.php';
require SYSPATH . '/router.php';

return $app;
