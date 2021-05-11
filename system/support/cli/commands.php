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
