<?php

declare(strict_types=1);

namespace common\models;

use common\base\Model;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use yii2tech\ar\position\PositionBehavior;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property string $id
 * @property int $number Номер заказа
 * @property string $clientId Клиент
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Clients $client
 * @property OrderToProducts[] $orderToProducts
 */
class Orders extends Model
{

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $addBehaviors = [
            'positionBehavior' => [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'number',
            ],
        ];

        return ArrayHelper::merge($behaviors, $addBehaviors);
    }

    public static function tableName(): string
    {
        return '{{%orders}}';
    }

    public function rules(): array
    {
        return [
            [['clientId',], 'required'],
            [['number'], 'integer'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['clientId'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::class, 'targetAttribute' => ['clientId' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'number' => 'Номер заказа',
            'clientId' => 'Клиент',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    public function getClient(): ActiveQuery
    {
        return $this->hasOne(Clients::class, ['id' => 'clientId']);
    }

    public function getOrderToProducts(): ActiveQuery
    {
        return $this->hasMany(OrderToProducts::class, ['orderId' => 'id']);
    }

    public function sumOrder(): float
    {
        return (float)OrderToProducts::find()->joinWith(['product'])
            ->where(['{{%order_to_products}}.orderId' => $this->id])
            ->sum('{{%order_to_products}}.countProduct * {{%products}}.price');
    }
}
