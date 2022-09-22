<?php

declare(strict_types=1);

namespace common\base;

use common\actions\base\CreateAction;
use common\actions\base\DeleteAction;
use common\actions\base\DeleteAllAction;
use common\actions\base\IndexAction;
use common\actions\base\UpdateAction;
use common\rbac\CollectionRolls;
use common\services\ServiceInterface;
use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{
    public ServiceInterface $service;

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [CollectionRolls::ROLE_SUPER_ADMIN],
                    ],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'index' => [
                'class' => IndexAction::class,
            ],
            'create' => [
                'class' => CreateAction::class,
                'modelClass' => $this->service->getModelClass(),
            ],
            'update' => [
                'class' => UpdateAction::class,
            ],
            'delete' => [
                'class' => DeleteAction::class,
            ],
            'delete-all' => [
                'class' => DeleteAllAction::class,
            ],
        ];
    }
}
