<?php

declare(strict_types=1);

namespace console\migrations\common;

use yii\db\Exception;
use yii\db\Migration;

class BaseMigration extends Migration
{
    public const TYPE_DRIVER_PGSQL = 'pgsql';
    public const TYPE_DRIVER_MYSQL = 'mysql';

    public string $typDriver;

    public function init(): void
    {
        parent::init();
        $this->typDriver = \Yii::$app->db->driverName;
    }

    /**
     * @throws Exception
     */
    public function setExtension(): void
    {
        if ($this->typDriver === self::TYPE_DRIVER_PGSQL) {
            $this->db->createCommand('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";')->execute();
        }
    }

    public function generalId(): \yii\db\ColumnSchemaBuilder|string
    {
        switch ($this->typDriver) {
            case self::TYPE_DRIVER_MYSQL:
                return $this->string()->unique();
                break;
            case self::TYPE_DRIVER_PGSQL:
                return 'uuid DEFAULT uuid_generate_v4() NOT NULL PRIMARY KEY';
                break;
        }
    }

    public function setPrimary(string $table)
    {
        if ($this->typDriver === self::TYPE_DRIVER_MYSQL) {
            $this->addPrimaryKey('id_pk_' . $table, '{{%' . $table . '}}', ['id']);
        }
    }

    public function generalIndex(bool $stateNull = false)
    {
        switch ($this->typDriver) {
            case self::TYPE_DRIVER_MYSQL:
                return $stateNull ? $this->string()->null() : $this->string()->notNull();
                break;
            case self::TYPE_DRIVER_PGSQL:
                return $stateNull ? 'uuid NULL' : 'uuid NOT NULL';
                break;
        }
    }


}