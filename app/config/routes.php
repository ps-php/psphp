<?php

$config['auto_route'] = true;
$config['default_controller'] = 'welcome';

$routes['/user/{uid:num}'] = 'user@detail';
