<?php

namespace api\controllers;

use yii\web\Controller;

class SiteController extends Controller
{

    public function actions(): array
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

}
