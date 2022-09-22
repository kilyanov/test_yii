<?php

declare(strict_types=1);

namespace api\modules\v1\search;

use api\modules\v1\records\order\Order;
use common\base\Model;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

class OrdersSearch extends Order
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
    public function search(string $clientId, array $params): array|object
    {
        $query = Order::find()->with(['client', 'orderToProducts'])->orderBy(['createdAt' => SORT_DESC]);//
        $this->load($params);
        $query->andWhere(['clientId' => $clientId]);
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
