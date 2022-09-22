<?php

declare(strict_types=1);

namespace api\modules\v1\controllers;

use api\modules\v1\actions\auth\Index;
use api\modules\v1\actions\auth\Logout;
use api\modules\v1\actions\auth\Refresh;
use api\modules\v1\form\auth\AuthForm;
use api\modules\v1\form\auth\LogoutForm;
use api\modules\v1\form\auth\RefreshForm;
use yii\helpers\ArrayHelper;
use yii\rest\OptionsAction;

class AuthController extends BaseApiController
{
    public string $modelClass = AuthForm::class;

    protected function verbs(): array
    {
        return [
            'index' => ['POST'],
            'refresh' => ['POST'],
            'logout' => ['POST'],
        ];
    }

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'except' => ['options', 'index', 'refresh', 'logout', ],
            ],
        ]);
    }

    public function actions(): array
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
            'index' => [
                'class' => Index::class,
                'modelClass' => $this->modelClass
            ],
            'refresh' => [
                'class' => Refresh::class,
                'modelClass' => RefreshForm::class
            ],
            'logout' => [
                'class' => Logout::class,
                'modelClass' => LogoutForm::class
            ],
        ];
    }
}
