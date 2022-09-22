<?php

declare(strict_types=1);

namespace backend\modules\orders\search;

use common\base\Model;
use common\models\Orders;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

class OrdersSearch extends Orders
{
    public function rules(): array
    {
        return [
            [
                [
                    'number',
                    'clientId',
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
        $query = Orders::find()->with(['client', 'orderToProducts'])->orderBy(['createdAt' => SORT_DESC]);//
        $this->load($params);
        if (!empty($this->number)) {
            $query->andWhere(['{{%orders}}.number' => $this->number]);
        }
        if (!empty($this->clientId)) {
            $query->joinWith(['client']);
            $query->andWhere(['like', '{{%clients}}.company', $this->clientId]);
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
