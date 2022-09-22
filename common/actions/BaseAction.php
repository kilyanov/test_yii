<?php

declare(strict_types=1);

namespace common\actions;

use common\base\Answer;
use common\base\BaseController;
use yii\base\Action;

class BaseAction extends Action
{
    public Answer $answer;

    /**
     * @var BaseController
     */
    public $controller;

}
