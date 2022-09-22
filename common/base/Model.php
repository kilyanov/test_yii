<?php

declare(strict_types=1);

namespace common\base;

use Carbon\Carbon;
use Ramsey\Uuid\Rfc4122\UuidV4;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class Model extends ActiveRecord
{
    public const DEFAULT_COUNT_ITEMS = 20;
    
    public const NOT_ACTIVE = 0;
    public const ACTIVE = 1;

    private bool $isAdmin = false;

    public function beforeValidate(): bool
    {
        if (\Yii::$app->db->driverName === 'mysql') {
            if($this->isNewRecord) {
                $this->id = UuidV4::uuid4()->toString();
            }
        }

        return parent::beforeValidate();
    }

    public function getCreatedAtValue(string $mask = 'd.m.Y H:i'): string
    {
        return date($mask, strtotime($this->createdAt));
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }
    
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['createdAt', 'updatedAt'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updatedAt']
                ],
                'value' => function () {
                    $carbon = new Carbon();
                    $carbon->format('Y-m-d H:i:s');
                    return $carbon->toDateTimeString();
                }
            ],
        ];
    }
    
    public static function find(bool $isDelete = true): ActiveQuery
    {
        return $isDelete ? (new ActiveQueryDelete(static::class)) :
            (new ActiveQuery(static::class));
    }
    
    public function deleteData(): int
    {
        $command = static::getDb()->createCommand();
        $command->delete(static::tableName(), ['id' => $this->id]);
        
        return $command->execute();
    }
    
    /**
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function delete()
    {
        if (!$this->beforeDelete()) {
            return false;
        }
        
        $transaction = static::getDb()->beginTransaction();
        try {
            $this->deletedAt = Carbon::now()->toDateTimeString();
            $result = $this->save();
            $this->afterDelete();
            if ($result === false) {
                $transaction->rollBack();
            } else {
                $transaction->commit();
            }
            
            return $result;
        } catch (\Exception | \Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    
    public static function deleteAll($condition = null, $params = [])
    {
        return static::updateAll(
            ['deletedAt' => Carbon::now()->toDateString()],
            $condition,
            $params
        );
    }
    
    public static function getStatusList(): array
    {
        return [
            self::NOT_ACTIVE => 'Не активный',
            self::ACTIVE => 'Активный',
        ];
    }
    
    public function getStatusValue(): string
    {
        if ($this->hasProperty('status')) {
            $list = self::getStatusList();
            return $list[$this->status];
        }
    }
    
}
