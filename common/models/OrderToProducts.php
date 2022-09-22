<?php

declare(strict_types=1);

namespace common\models;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%order_to_products}}".
 *
 * @property string $id
 * @property string $orderId Заказ
 * @property string $productId Товар
 * @property integer $countProduct Кол-во
 *
 * @property Orders $order
 * @property Products $product
 */
class OrderToProducts extends \yii\db\ActiveRecord
{
    public function beforeValidate(): bool
    {
        if (\Yii::$app->db->driverName === 'mysql') {
            if($this->isNewRecord) {
                $this->id = UuidV4::uuid4()->toString();
            }
        }

        return parent::beforeValidate();
    }

    public static function tableName(): string
    {
        return '{{%order_to_products}}';
    }

    public function rules(): array
    {
        return [
            [['orderId', 'productId', 'countProduct'], 'required'],
            ['countProduct', 'integer'],
            [['orderId'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['orderId' => 'id']],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['productId' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'orderId' => 'Заказ',
            'productId' => 'Товар',
            'countProduct' => 'Кол-во',
        ];
    }

    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(Orders::class, ['id' => 'orderId']);
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Products::class, ['id' => 'productId']);
    }
}
