<?php

declare(strict_types=1);

namespace common\actions\base;

use Yii;
use common\actions\BaseAction;

class IndexAction extends BaseAction
{

    public function run(): string
    {
        return $this->controller->render(
            'index',
            $this->controller->service->search(Yii::$app->request->queryParams)
        );
    }
}
