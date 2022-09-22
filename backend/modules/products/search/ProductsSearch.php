<?php

declare(strict_types=1);

namespace backend\modules\products\search;

use common\base\Model;
use common\models\Products;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

class ProductsSearch extends Products
{
    public function rules(): array
    {
        return [
            [
                [
                    'name',
                    'price',
                ],
                'safe',
            ],
        ];
    }
    
    /**
     * @throws InvalidConfigException
     */
    public function search(array $params): array|object
    {
        $query = Products::find()->orderBy(['createdAt' => SORT_DESC]);
        $this->load($params);
        if (!empty($this->name)) {
            $query->andWhere(['like', 'name', $this->name]);
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $query,
            'pagination' => [
                'params' => $params,
                'pageSizeLimit' => [1, Model::DEFAULT_COUNT_ITEMS],
            ],
        ]);
    }
}
