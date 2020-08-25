<?php
return [
    'adminPanel' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'schema' => [
        'type' => 2,
    ],
    'smena' => [
        'type' => 2,
    ],
    'takeSmena' => [
        'type' => 2,
    ],
    'giveSmena' => [
        'type' => 2,
    ],
    'switch' => [
        'type' => 2,
    ],
    'indexRecord' => [
        'type' => 2,
    ],
    'createRecord' => [
        'type' => 2,
    ],
    'updateRecord' => [
        'type' => 2,
        'ruleName' => 'isAuthor',
    ],
    'viewRecord' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'children' => [
            'index',
            'error',
            'login',
            'logout',
            'schema',
            'indexRecord',
        ],
    ],
    'operator' => [
        'type' => 1,
        'children' => [
            'smena',
            'takeSmena',
            'giveSmena',
            'switch',
            'createRecord',
            'updateRecord',
            'viewRecord',
            'guest',
        ],
    ],
    'engineer' => [
        'type' => 1,
        'children' => [
            'smena',
            'guest',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'adminPanel',
            'operator',
            'engineer',
        ],
    ],
];
