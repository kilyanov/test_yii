<?php

declare(strict_types=1);

namespace api\modules\v1\controllers;

use api\modules\v1\actions\order\Index;
use api\modules\v1\records\order\Order;
use yii\rest\OptionsAction;

class OrderController extends BaseApiController
{
    public string $modelClass = Order::class;

    protected function verbs(): array
    {
        return [
            'index' => ['GET'],
        ];
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
        ];
    }
}
