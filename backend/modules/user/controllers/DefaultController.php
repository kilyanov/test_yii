<?php

declare(strict_types=1);

namespace backend\modules\user\controllers;

use backend\modules\user\services\UserService;
use common\base\BaseController;

class DefaultController extends BaseController
{
    public function init(): void
    {
        parent::init();
        $this->service = new UserService();
    }
}
