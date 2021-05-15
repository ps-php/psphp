<?php
// Colorize the terminal
function colorLog(string $str, string $type) {
    switch ($type) {
        case 'e': //error
            $str = "\033[31m$str\033[0m";
        break;
        case 's': //success
            $str = "\033[32m$str\033[0m";
        break;
        case 'w': //warning
            $str = "\033[33m$str\033[0m";
        break;  
        case 'i': //info
            $str = "\033[36m$str\033[0m";
        break;      
        default:
            $str = $str;
        break;
    }

    return $str;
}

function _cli__parseArguments() {
    $args = $_SERVER['argv'];
    $command = $args[1] ?? 'help';
    $param = $args[2] ?? null;

    $exp = explode(':', $command);

    return [
        'command' => [$exp[0], $exp[1] ?? null],
        'param' => $param
    ];
}

function _cli__createDir(string $path) {
    $exp = explode('/', $path);
    array_pop($exp);
    @mkdir(implode('/', $exp));
}

function _cli_createFile(string $path, string $str) {
    _cli__createDir($path);
    $create = fopen($path, "w") or die(colorLog("Permission denied\n", 'e'));
    fwrite($create, $str);
    fclose($create);

    return $path;
}

function _cli__callCommand(string $command, $type, $param) {
    require SYSPATH . '/support/cli/commands.php';
    
    if(!is_callable($command)) die(colorLog("Error: command not found\n", 'e'));
    return $command($type, $param);
}
