<?php

use yii\queue\file\Queue;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'scop 2.1',
    'name'=>'Маяк-Энергия',
    'language' => 'ru_RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'BeGT$fjtM_FEn73jr_Rkdedsfgv8RwNk',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'=>['auth/login'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['guest'],
            'itemFile' => '@app/rbac/items.php',
            'assignmentFile' => '@app/rbac/assignments.php',
            'ruleFile' => '@app/rbac/rules.php',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/device',
                    'pluralize' => false,
                ],
            ],
        ],
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@runtime/queue',
            'as log' => \yii\queue\LogBehavior::class,
            'ttr' => 1 * 60, // Максимальное время выполнения задания
            'attempts' => 5 // Максимальное кол-во попыток
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
             'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    'params' => $params,    
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'queue' => \yii\queue\debug\Panel::class,
        ],
        'allowedIPs' => ['192.168.71.111', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['192.168.71.111', '::1'],
    ];
}

return $config;
