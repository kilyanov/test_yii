<?php

declare(strict_types=1);

namespace common\actions\base;

use common\base\Answer;
use Yii;
use common\actions\BaseAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CreateAction extends BaseAction
{
    public string $modelClass;

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
                $result = $this->controller->service->create($this->answer->model->getAttributes());
                if ($result === true) {
                    return $this->answer->isPost(['create']);
                }
                else {
                    return $this->answer->isContentAction($result);
                }
            } else {
                return $this->answer->isErrorAction();
            }
        } else {
            throw new NotFoundHttpException('Request is not Ajax.');
        }

    }

    public function beforeRun(): bool
    {
        $modelClass = $this->modelClass;
        $this->answer = new Answer([
            'model' => new $modelClass($this->controller->service->getCfgModel()),
            'tmp' => 'create',
            'title' => 'Создать запись',
            'forceReload' => Answer::DEFAULT_FORCE_RELOAD
        ]);

        return true;
    }

}
