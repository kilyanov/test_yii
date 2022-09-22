<?php

declare(strict_types=1);

namespace common\models;

use common\base\Model;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property string $id
 * @property string $name Название товара
 * @property float $price Цена
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property OrderToProducts[] $orderToProducts
 */
class Products extends Model
{

    public static function tableName(): string
    {
        return '{{%products}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'price',], 'required'],
            [['price'], 'number'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название товара',
            'price' => 'Цена',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    public function getOrderToProducts(): ActiveQuery
    {
        return $this->hasMany(OrderToProducts::class, ['productId' => 'id']);
    }
}
