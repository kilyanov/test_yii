<?php

declare(strict_types=1);

namespace common\services;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BaseService implements ServiceInterface
{
    protected string $nameAttr;

    protected string $modelClass;
    private array $cfgModel = [];

    protected string $searchModelClass;
    private array $cfgSearchModel = [];

    public function getCfgModel(): array
    {
        return $this->cfgModel;
    }

    public function setCfgModel(array $cfgParams): void
    {
        $this->cfgModel = ArrayHelper::merge($this->cfgModel, $cfgParams);
    }

    public function getCfgSearchModel(): array
    {
        return $this->cfgSearchModel;
    }

    public function setCfgSearchModel(array $cfgParams): void
    {
        $this->cfgSearchModel = ArrayHelper::merge($this->cfgSearchModel, $cfgParams);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function find(string $id): Model
    {
        $class = $this->modelClass;
        $model = $class::findOne(['id' => $id]);

        if ($model === null) {
            throw new NotFoundHttpException("Records with ID# {$id} not found.");
        }

        return $model;
    }

    public function search(array $params): array
    {
        $searchClass = $this->searchModelClass;
        $model = new $searchClass($this->cfgSearchModel);
        $dataProvider = $model->search($params);

        return [
            'model' => $model,
            'dataProvider' => $dataProvider
        ];
    }

    public function create(array $params): bool|string
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass($params);
        return $model->save() ? true : implode(',', $model->getFirstErrors());
    }

    /**
     * @throws NotFoundHttpException
     */
    public function update(Model $model): bool|string
    {
        return $model->save() ? true : implode(',', $model->getFirstErrors());
    }

    /**
     * @throws NotFoundHttpException
     */
    public function delete(Model $model): bool|string
    {
        return $model->delete();
    }

    public function deleteAll(array $params): bool|string
    {
        $class = $this->modelClass;
        $result = $class::deleteAll(['id' => $params]);
        return is_int($result) ? true : 'Ошибка удаления записей.';
    }

    public function load(string $q = '', ?string $id = null): array
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        $modelClass = $this->modelClass;
        if (!is_null($q)) {
            $models = $this->loadSearch($q);
            if (count($models) > 0) {
                $data = [];
                foreach ($models as $model) {
                    $data[] = $this->valueLoad($model);
                }
                $out['results'] = $data;
            }
        } elseif ($id > 0) {
            $m = $modelClass::findOne($id);
            $out['results'] = $this->valueLoad($m);
        }

        return $out;
    }

    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    public function valueLoad(Model $model): array
    {
        // TODO: Implement valueLoad() method.
    }

    public function loadSearch(string $q = ''): array
    {
        $modelClass = $this->modelClass;
        return $modelClass::find()
                ->andWhere(['like', $this->nameAttr, $q])
                ->limit(50)
                ->all();

    }
}
