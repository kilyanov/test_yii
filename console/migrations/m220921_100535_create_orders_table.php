<?php

declare(strict_types=1);

use console\migrations\common\BaseMigration;

class m220921_100535_create_orders_table extends BaseMigration
{
    const TABLE_NAME = 'orders';
    private string $table = '{{%' . self::TABLE_NAME . '}}';
    private string $client = '{{%clients}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->generalId(),
            'number' => $this->integer()->notNull()->comment('Номер заказа'),
            'clientId' => $this->string()->notNull()->comment('Клиент'),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
            'deletedAt' => $this->dateTime()->null(),
        ]);
        $this->setPrimary(self::TABLE_NAME);
        $this->createIndex(
            'idx-clientId-'.self::TABLE_NAME,
            $this->table,
            'clientId'
        );
        $this->addForeignKey(
            'fk-clientId-'.self::TABLE_NAME,
            $this->table,
            'clientId',
            $this->client,
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-clientId-'.self::TABLE_NAME, $this->table);
        $this->dropTable($this->table);
    }
}
