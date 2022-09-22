<?php

declare(strict_types=1);

use console\migrations\common\BaseMigration;

class m220921_094113_create_clients_table extends BaseMigration
{
    const TABLE_NAME = 'clients';
    private string $table = '{{%' . self::TABLE_NAME . '}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->generalId(),
            'fio' => $this->string()->notNull()->comment('ФИО'),
            'company' => $this->string()->notNull()->comment('Компания'),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
            'deletedAt' => $this->dateTime()->null(),
        ]);
        $this->setPrimary(self::TABLE_NAME);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
