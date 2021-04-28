<?php

$validation = [
    'login' => [
        'username' => [
            'label' => 'User Name',
            'rules' => 'required|min_length[4]'
        ],
        'password' => 'required'
    ]
];

return $validation;
