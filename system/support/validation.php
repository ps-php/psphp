<?php

function _validation_set_error(string $name, string $message) {
    $_SESSION['validation'][$name] = $message;
}

function _validation_get_value($name) {
    return $_POST[$name] ?? null;
}

function _validation_rule_required($name, $label) {
    $value = _validation_get_value($name);

    if($value) return true;

    _validation_set_error($name, "$label field is required");
    return false;
}

function _validation_rule_min_length($name, $label, int $length) {
    $value = trim(_validation_get_value($name));

    if(strlen($value) >= $length) return true;

    _validation_set_error($name, "$label field is at least $length character");
    return false;
}
