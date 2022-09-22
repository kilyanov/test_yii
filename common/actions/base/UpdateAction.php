<?php

declare(strict_types=1);

namespace common\actions\base;

use common\base\Answer;
use Yii;
use common\actions\BaseAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UpdateAction extends BaseAction
{
    /**
     * @throws NotFoundHttpException
     */
    public function run(): array
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return $this->answer->isGet();
            } else if ($this->answer->model->load($request->post())
                && $this->answer->model->validate()) {
                $result = $this->controller->service->update($this->answer->model);
                if ($result === true) {
                    return $this->answer->isContentAction('Данные успешно сохранены!');
                }
                else {
                    return $this->answer->isContentAction($result);
                }
            } else {
                return $this->answer->isGet();
            }
        } else {
            throw new NotFoundHttpException('Request is not Ajax.');
        }

    }

    public function runWithParams($params)
    {
        $this->answer = new Answer([
            'model' => $this->controller->service->find((string)$params['id']),
            'tmp' => 'update',
            'title' => 'Редактирование записи'
        ]);

        return parent::runWithParams($params);
    }

}
