<?php

declare(strict_types=1);

namespace api\modules\swagger\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function actionSwagger()
    {
        $token = 'test';

        Yii::$app->response->headers->set('content-type', 'application/json');
        Yii::$app->response->headers->set('Authorization', "Bearer $token");
        Yii::$app->response->format = 'json';

        $openapi = \OpenApi\scan(Yii::getAlias('@api/modules/v1'));

        return json_decode($openapi->toJson(  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}