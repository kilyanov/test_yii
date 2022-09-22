<?php

declare(strict_types=1);

namespace common\actions\base;

use common\base\Answer;
use Yii;
use common\actions\BaseAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeleteAction extends BaseAction
{
    public function run(): array
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->answer->model->delete();

            return $this->answer->getDelete();
        } else {
            throw new NotFoundHttpException('Request is not Ajax.');
        }

    }

    public function runWithParams($params)
    {
        $this->answer = new Answer([
            'model' => $this->controller->service->find((string)$params['id']),
            'tmp'   => '',
            'title' => 'Удаление данных'
        ]);

        return parent::runWithParams($params);
    }

}
