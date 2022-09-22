<?php

declare(strict_types=1);

use console\migrations\common\BaseMigration;

class m220616_030055_create_user_token_table extends BaseMigration
{
    const TABLE_NAME = 'user_token';
    private string $table = '{{%' . self::TABLE_NAME . '}}';
    private string $user = '{{%user}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->generalId(),
            'userId' => $this->generalIndex(),
            'type' => $this->integer()->notNull(),
            'token' => $this->text()->notNull(),
            'expiredAt' => $this->dateTime()->notNull(),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
        ]);
        $this->setPrimary(self::TABLE_NAME);
        $this->createIndex(
            'idx-userId-' . self::TABLE_NAME,
            $this->table,
            'userId'
        );
        $this->addForeignKey(
            'fk-userId-' . self::TABLE_NAME,
            $this->table,
            'userId',
            $this->user,
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-userId-' . self::TABLE_NAME, $this->table);
        $this->dropTable($this->table);
    }
}
