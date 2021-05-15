<?php

function _cli__helpCommand() {
    $cmds = _supported__commands();
    $mask = " %-20s %-s \n";
    
    foreach($cmds as $cmd => $desc) {
        if(is_array($desc)) {
            foreach($desc as $name => $val) {
                printf($mask, "$cmd:$name", $val);
            }
            continue;
        }

        printf($mask, $cmd, $desc);
    }
}

function _cli__serveCommand() {
    $port = 8080;

    while(is_resource(@fsockopen("localhost:$port"))) {
        echo "Address already in use\n";
        $port++;
        echo "Trying on http://localhost:$port\n...\n";
    }
    
    echo "Development server started on http://localhost:$port\n";
    shell_exec("php -S localhost:$port -t " . FCPATH);
}

// "make" command block
function _cli_mControllerCommand($name) {
    $path = APPPATH . "/controllers/$name.php";
    if(is_file($path)) die("Controller $name is already exist\n\n");

    $str = "<?php

function index() {
    
}
    ";

    _cli_createFile($path, $str);
}

function _cli_mModelCommand($name) {
    $path = APPPATH . "/models/$name.php";
    if(is_file($path)) die("Model $name is already exist\n\n");

    $str = "<?php

function get() {
    
}
    ";

    _cli_createFile($path, $str);
}

function _cli_mViewCommand($name) {
    $path = APPPATH . "/views/$name.php";
    if(is_file($path)) die("View $name is already exist\n\n");
    $str = "";

    _cli_createFile($path, $str);
}

function _cli__makeCommand(string $type, $param) {
    $func = "_cli_m".ucfirst($type)."Command";
    
    if(!is_callable($func)) {
        die("Command make:$type is not found\n\n");
    }

    $func($param);
    echo ucfirst($type) . " $param created successfully";
}
