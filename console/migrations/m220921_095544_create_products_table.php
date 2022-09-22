<?php

declare(strict_types=1);

use console\migrations\common\BaseMigration;

class m220921_095544_create_products_table extends BaseMigration
{
    const TABLE_NAME = 'products';
    private string $table = '{{%' . self::TABLE_NAME . '}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->generalId(),
            'name' => $this->string()->notNull()->comment('Название товара'),
            'price' => $this->decimal(10,2)->notNull()->comment('Цена'),
            'createdAt' => $this->dateTime()->notNull(),
            'updatedAt' => $this->dateTime()->notNull(),
            'deletedAt' => $this->dateTime()->null(),
        ]);
        $this->setPrimary(self::TABLE_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
