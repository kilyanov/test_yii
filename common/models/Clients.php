<?php

declare(strict_types=1);

namespace common\models;

use common\base\Model;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%clients}}".
 *
 * @property string $id
 * @property string $fio ФИО
 * @property string $company Компания
 * @property string $createdAt
 * @property string $updatedAt
 * @property string|null $deletedAt
 *
 * @property Orders[] $orders
 */
class Clients extends Model
{
    public static function tableName(): string
    {
        return '{{%clients}}';
    }

    public function rules(): array
    {
        return [
            [['fio', 'company',], 'required'],
            [['createdAt', 'updatedAt', 'deletedAt'], 'safe'],
            [['fio', 'company'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'company' => 'Компания',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'deletedAt' => 'Deleted At',
        ];
    }

    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Orders::class, ['clientId' => 'id']);
    }
}
