<?php
/*
| Application Config
*/
$config['base_url'] = "http://localhost/psphp/";
$config['default_controller'] = 'welcome';
/*
| Database Connection
| Only Support for MySQL through mysqli driver
*/
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', '');
/*
| For require vendor/autoload file
| Set true if you would use the composer packages
*/
$config['composer_autoload'] = false;
