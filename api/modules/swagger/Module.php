<?php

namespace api\modules\swagger;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\swagger\controllers';

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
}