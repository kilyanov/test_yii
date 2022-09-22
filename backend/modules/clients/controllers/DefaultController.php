<?php

declare(strict_types=1);

namespace backend\modules\clients\controllers;

use backend\modules\clients\services\ClientService;
use common\base\BaseController;

class DefaultController extends BaseController
{
    public function init(): void
    {
        parent::init();
        $this->service = new ClientService();
    }
}
