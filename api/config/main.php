<?php

use bizley\jwt\Jwt;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use yii\rbac\DbManager;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$urlManagerV1Rules = require(__DIR__ . '/../modules/v1/urlManagerRules.php');
$urlManagerSwaggerRules = require(__DIR__ . '/../modules/swagger/urlManagerRules.php');

return [
    'language' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => api\modules\v1\Module::class,
        ],
        'swagger' => [
            'basePath' => '@app/modules/swagger',
            'class' => api\modules\swagger\Module::class
        ],
    ],
    'aliases' => [
        '@api' => dirname(__DIR__, 2) . '/api',
    ],
    'components' => [
        'response' => [
            'format' => 'json',
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ]
            ]
        ],
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => yii\web\JsonParser::class,
                'multipart/form-data' => yii\web\MultipartFormDataParser::class
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-api',
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
            'rules' => array_merge($urlManagerV1Rules, $urlManagerSwaggerRules),
        ],
        'jwt' => [
            'class' => Jwt::class,
            'signer' => Jwt::RS256,
            'signingKey' => '@api/runtime/jwtRS256.key',
            'verifyingKey' => '@api/runtime/jwtRS256.key.pub',
            'validationConstraints' => [
                [
                    function() {
                        return Yii::createObject(LooseValidAt::class, [
                            'clock' => SystemClock::fromUTC(),
                        ]);
                    },
                ],
                [
                    function() {
                        $builder = Yii::$app->jwt->getConfiguration();
                        return Yii::createObject(SignedWith::class, [
                            'signer' => $builder->signer(),
                            'key' => $builder->verificationKey(),
                        ]);
                    },
                ],
            ],
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
    ],
    'params' => $params,
];
