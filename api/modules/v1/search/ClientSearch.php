<?php

declare(strict_types=1);

namespace api\modules\v1\search;

use api\modules\v1\records\order\Client;
use common\base\Model;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

class ClientSearch extends Client
{
    public function rules(): array
    {
        return [
            [
                [
                    'fio',
                    'company',
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
        $query = Client::find()->orderBy(['createdAt' => SORT_DESC]);
        $this->load($params);
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
