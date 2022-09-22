<?php

declare(strict_types=1);

namespace api\modules\v1\controllers;

use api\modules\v1\actions\client\Index;
use api\modules\v1\records\order\Client;
use yii\rest\OptionsAction;

class ClientController extends BaseApiController
{
    public string $modelClass = Client::class;

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
