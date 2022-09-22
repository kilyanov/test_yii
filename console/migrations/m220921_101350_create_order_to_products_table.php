<?php

declare(strict_types=1);

use console\migrations\common\BaseMigration;

class m220921_101350_create_order_to_products_table extends BaseMigration
{

    const TABLE_NAME = 'order_to_products';
    private string $table = '{{%' . self::TABLE_NAME . '}}';
    private string $product = '{{%products}}';
    private string $orders = '{{%orders}}';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->generalId(),
            'orderId' => $this->string()->notNull()->comment('Заказ'),
            'productId' => $this->string()->notNull()->comment('Товар'),
            'countProduct' => $this->integer()->notNull()->comment('Кол-во'),
        ]);
        $this->setPrimary(self::TABLE_NAME);
        $this->createIndex(
            'idx-orderId-'.self::TABLE_NAME,
            $this->table,
            'orderId'
        );
        $this->addForeignKey(
            'fk-orderId-'.self::TABLE_NAME,
            $this->table,
            'orderId',
            $this->orders,
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-productId-'.self::TABLE_NAME,
            $this->table,
            'productId'
        );
        $this->addForeignKey(
            'fk-productId-'.self::TABLE_NAME,
            $this->table,
            'productId',
            $this->product,
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-orderId-'.self::TABLE_NAME, $this->table);
        $this->dropForeignKey('fk-productId-'.self::TABLE_NAME, $this->table);
        $this->dropTable($this->table);
    }
}
