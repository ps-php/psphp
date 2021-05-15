<?php

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

function _cli_createFile(string $path, string $str) {
    $create = fopen($path, "w") or die("Permission denied");
    fwrite($create, $str);
    fclose($create);

    return $path;
}

function _cli__callCommand(string $command, $type, $param) {
    require SYSPATH . '/support/cli/commands.php';
    
    if(!is_callable($command)) die("Error: command not found\n");
    return $command($type, $param);
}
