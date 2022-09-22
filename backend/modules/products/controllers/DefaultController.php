<?php

declare(strict_types=1);

namespace backend\modules\products\controllers;

use backend\modules\products\services\ProductService;
use common\base\BaseController;
use common\rbac\CollectionRolls;
use yii\filters\AccessControl;

class DefaultController extends BaseController
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [CollectionRolls::ROLE_USER],
                    ],
                ],
            ],
        ];
    }

    public function init(): void
    {
        parent::init();
        $this->service = new ProductService();
    }
}
