<?php

declare(strict_types=1);

namespace api\modules\v1\records\order;

use OpenApi\Annotations as OA;
use Yii;
use common\models\Orders as OrdersModel;
use Carbon\Carbon;
use yii\db\ActiveQuery;

/**
 * @OA\Schema(title="Заказ")
 */
class Order extends OrdersModel
{
    /**
     * @OA\Property(property="id", type="string", format="uuid", description="ID пользователя")
     * @OA\Property(property="number", type="integer", description="Номер заказа")
     * @OA\Property(property="clientId", type="string", format="uuid", description="Клиент")
     * @OA\Property(property="sum", type="number", description="Сумма заказа")
     * @OA\Property(property="createdAt", type="string", description="Дата создания")
     * @OA\Property(property="updatedAt", type="string", description="Дата обновления")
     */
    public function fields(): array
    {
        return [
            'id',
            'number',
            'clientId',
            'sum' => function($model) {
                return $model->sumOrder();
            },
            'createdAt' => function($model) {
                return Carbon::parse($model->createdAt, Yii::$app->timeZone)->toRfc3339String();
            },
            'updatedAt' => function($model) {
                return Carbon::parse($model->updatedAt, Yii::$app->timeZone)->toRfc3339String();
            },
        ];
    }

    public function extraFields(): array
    {
        return [
            'client',
        ];
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Client::class, ['id' => 'clientId']);
    }

}
