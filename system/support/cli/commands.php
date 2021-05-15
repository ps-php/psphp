<?php

function _cli__helpCommand() {
    $cmds = _supported__commands();
    $mask = " %-30s %-s \n";
    
    foreach($cmds as $cmd => $desc) {
        if(is_array($desc)) {
            foreach($desc as $name => $val) {
                printf($mask, colorLog("$cmd:$name", 's'), $val);
            }
            continue;
        }

        printf($mask, colorLog($cmd, 's'), $desc);
    }
}

function _cli__serveCommand() {
    $port = 8080;

    while(is_resource(@fsockopen("localhost:$port"))) {
        echo colorLog("Address already in use\n", 'w');
        $port++;
        echo "Trying on http://localhost:$port\n ...\n";
    }
    
    echo colorLog("Development server started on http://localhost:$port\n", 's');
    shell_exec("php -S localhost:$port -t " . FCPATH);
}

// "make" command block
function _cli_mControllerCommand($name) {
    $path = APPPATH . "/controllers/$name.php";
    if(is_file($path)) die(colorLog("Controller $name is already exist\n\n", 'e'));

    $str = "<?php

function index() {
    
}
    ";

    _cli_createFile($path, $str);
}

function _cli_mModelCommand($name) {
    $path = APPPATH . "/models/$name.php";
    if(is_file($path)) die(colorLog("Model $name is already exist\n\n", 'e'));

    $str = "<?php

function get() {
    
}
    ";

    _cli_createFile($path, $str);
}

function _cli_mViewCommand($name) {
    $path = APPPATH . "/views/$name.php";
    if(is_file($path)) die(colorLog("View $name is already exist\n\n", 'e'));
    $str = "";

    _cli_createFile($path, $str);
}

function _cli__makeCommand(string $type, $param) {
    $func = "_cli_m".ucfirst($type)."Command";
    
    if(!is_callable($func)) {
        die(colorLog("Command make:$type is not found\n\n", 'e'));
    }

    $func($param);
    echo colorLog(ucfirst($type) . " $param created successfully", 's');
}
