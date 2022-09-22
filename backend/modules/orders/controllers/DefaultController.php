<?php

declare(strict_types=1);

namespace backend\modules\orders\controllers;

use backend\modules\orders\services\OrderService;
use common\base\BaseController;

class DefaultController extends BaseController
{
    public function init(): void
    {
        parent::init();
        $this->service = new OrderService();
    }
}
