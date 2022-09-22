<?php

declare(strict_types=1);

use common\models\Products;
use yii\db\Migration;

/**
 * Class m220921_124154_add_data_to_products_table
 */
class m220921_124154_add_data_to_products_table extends Migration
{
    public const TABLE_NAME = 'clients';

    private string $table = '{{%' . self::TABLE_NAME . '}}';

    public function safeUp()
    {
        for ($i = 1; $i < 1000; $i++) {
            $add = new Products([
                'name' => 'name ' . $i,
                'price' => rand(500, 35000),
            ]);
            $add->save();
            echo 'OK ADD Products ID ' . $add->id . PHP_EOL;
        }
    }

    public function safeDown()
    {
        $this->delete($this->table, 'id is not null');
    }
}
