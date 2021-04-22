<?php
/*
| Application Config
*/
$config['app_environment'] = 'development';
$config['app_name'] = 'Ps-PHP';
$config['base_url'] = "http://localhost/psphp/";
$config['helper_suffix'] = '.helper';
/*
| CSRF Token config
*/
$config['csrf_token_name'] = 'psphp_csrf';
$config['csrf_token_expires'] = 3600;
$config['csrf_regenerate'] = true;
/*
| Database Connection
| Only Support for MySQL through mysqli driver
*/
$config['db_host'] = '127.0.0.1';
$config['db_username'] = 'root';
$config['db_password'] = '';
$config['db_name'] = 'psphp';
/*
| For require vendor/autoload file
| Set true if you would use the composer packages
*/
$config['composer_autoload'] = false;
