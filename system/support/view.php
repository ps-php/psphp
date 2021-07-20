<?php
$GLOBALS['view'] = [];

function _view__getSectionName($content) {
    if(preg_match('/{sname-(.*?)-endsname}/', $content, $match)) {
        return $match[1] ?? null;
    }

    return null;
}

function _view__replaceYield($section, $name) {
    $content = $GLOBALS['view']['extend'];
    return str_replace("{psy-$name-endpsy}", $section, $content);
}

function _view__cleanContent($content) {
    $content = preg_replace('/{sname-(.*?)-endsname}/', '', $content);
    $content = preg_replace('/{psy-(.*?)-endpsy}/', '', $content);

    return $content;
}

function __extend($view, $data = []) {
    if(file_exists($path = APPPATH . "/views/$view.php")) {
        ob_start();
        extract($data);
        
        require $path;
        $GLOBALS['view']['extend'] = ob_get_contents();
        ob_get_clean();
    } else {
        throw new Exception("View $view is not found");
    }
}

function __yield($name) {
    $extend = $GLOBALS['view']['extend'] ?? false;
    return ($extend) ? "{psy-$name-endpsy}" : '';
}

function __section($name) {
    ob_start();
    echo "{sname-$name-endsname}";
}

function __endSection() {
    $section = ob_get_contents();
    $name = _view__getSectionName($section);

    $GLOBALS['view']['extend'] = _view__replaceYield($section, $name);
    ob_get_clean();
}

function __include($view) {
    if(file_exists($path = APPPATH . "/views/$view.php")) {
        extract($GLOBALS['psview-data']);
        require $path;
    } else {
		throw new Exception("View $view is not found");
	}
}
