<?php

use yii\rbac\DbManager;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'name' => 'TEST-YII',
    'language' => 'ru-RU',
    'id' => 'TEST-YII',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
        'products' => [
            'class' => 'backend\modules\products\Module',
        ],
        'clients' => [
            'class' => 'backend\modules\clients\Module',
        ],
        'orders' => [
            'class' => 'backend\modules\orders\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'products/default/update/<id:[\w\-]+>' => 'products/default/update',
                'products/default/delete/<id:[\w\-]+>' => 'products/default/delete',
                'clients/default/update/<id:[\w\-]+>' => 'clients/default/update',
                'clients/default/delete/<id:[\w\-]+>' => 'clients/default/delete',
            ],
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
    ],
    'params' => $params,
];
