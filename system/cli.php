<?php

require SYSPATH . '/support/cli/common.php';

function _supported__commands() {
    return [
        'help' => 'Show the list of available commands',
        'serve' => 'Launch the development server',
        'make' => [
            'model' => 'Generate a new model file',
            'view' => 'Generate a new view file',
            'controller' => 'Generate a new controller file'
        ]
    ];
}

function _handle_CLI() {
    $args = _cli__parseArguments();
    $cmds = _supported__commands();

    if(!array_key_exists($args['command'][0], $cmds)) {
        die("Command doesn't supported \n");
    }

    $command = '_cli__' . $args['command'][0] . 'Command';
    echo "\n Ps-PHP Command Line Tool \n\n";
    _cli__callCommand($command, $args['command'][1], $args['param']);
    echo "\n\n";
}
