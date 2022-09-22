<?php

declare(strict_types=1);

namespace common\actions\base;

use common\base\Answer;
use Yii;
use common\actions\BaseAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeleteAllAction extends BaseAction
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(): array
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $pks = explode(',', $request->post('pks'));
            if (!empty($pks)) {
                $this->controller->service->deleteAll($pks);
            }

            return $this->answer->getDelete();
        } else {
            throw new NotFoundHttpException('Request is not Ajax.');
        }
    }

    public function beforeRun(): bool
    {
        $this->answer = new Answer([
            'tmp' => '',
            'title' => 'Удаление данных'
        ]);

        return true;
    }

}
