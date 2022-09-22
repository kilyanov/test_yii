<?php

declare(strict_types=1);

namespace backend\modules\clients\search;

use common\base\Model;
use common\models\Clients;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

class ClientsSearch extends Clients
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
        $query = Clients::find()->orderBy(['createdAt' => SORT_DESC]);
        $this->load($params);
        if (!empty($this->fio)) {
            $query->andWhere(['like', 'fio', $this->fio]);
        }
        if (!empty($this->company)) {
            $query->andWhere(['like', 'company', $this->company]);
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
