<?php

declare(strict_types=1);

namespace backend\modules\user\search;

use common\base\Model;
use common\models\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules(): array
    {
        return [
            [
                [
                    'username',
                    'email',
                    'status',
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
        $query = User::find()->orderBy(['createdAt' => SORT_DESC]);
        $this->load($params);
        if (!empty($this->username)) {
            $query->andWhere(['like', 'username', $this->username]);
        }
        if (!empty($this->email)) {
            $query->andWhere(['like', 'email', $this->email]);
        }
        if ($this->status != '') {
            $query->andWhere(['status' => $this->status]);
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
