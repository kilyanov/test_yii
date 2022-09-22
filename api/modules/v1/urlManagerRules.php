<?php

declare(strict_types=1);

use yii\rest\UrlRule;

return [
    [
        'class' => UrlRule::class,
        'controller' => 'v1/auth',
        'patterns' => [
            'POST' => 'index',
            'OPTIONS' => 'options',
            'POST refresh' => 'refresh',
            'OPTIONS refresh' => 'options',
            'POST logout' => 'logout',
            'OPTIONS logout' => 'options',
        ],
        'pluralize' => false,
    ],
    [
        'class' => UrlRule::class,
        'controller' => 'v1/order',
        'patterns' => [
            'GET {client}' => 'index',
        ],
        'tokens' => [
            '{client}' => '<client:[a-f0-9-]{36}>',
        ],
        'pluralize' => false,
    ],
    [
        'class' => UrlRule::class,
        'controller' => 'v1/client',
        'patterns' => [
            'GET' => 'index',
        ],
        'pluralize' => false,
    ],
];
