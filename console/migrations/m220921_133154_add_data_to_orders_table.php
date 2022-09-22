<?php

declare(strict_types=1);

use common\models\Clients;
use common\models\Orders;
use common\models\OrderToProducts;
use common\models\Products;
use Ramsey\Uuid\Rfc4122\UuidV4;
use yii\db\Migration;

/**
 * Class m220921_133154_add_data_to_orders_table
 */
class m220921_133154_add_data_to_orders_table extends Migration
{
    public const TABLE_NAME = 'orders';

    private string $table = '{{%' . self::TABLE_NAME . '}}';

    private string $order_to_products = '{{%order_to_products}}';

    public function up()
    {
        $clients = Clients::find()->select(['id'])
            ->orderBy('createdAt')->asArray()->all();
        $products = Products::find()->select(['id'])
            ->orderBy('createdAt')->asArray()->all();
        for ($i = 1; $i <= 1000; $i++) {
            $rand = rand(1, 950);
            $add = new Orders([
                'clientId' => $clients[$rand]['id']
            ]);
            if ($add->save()) {
                echo 'OK ADD ORDERS ID ' . $add->id . PHP_EOL;
                $countProduct = rand(2, 5);
                for ($j = 1; $j < $countProduct; $j++) {
                    $rand = rand(1, 950);
                    $this->insert($this->order_to_products,[
                        'id' => UuidV4::uuid4()->toString(),
                        'orderId' => $add->id,
                        'productId' => $products[$rand]['id'],
                        'countProduct' => rand(1, 5),
                    ]);
                }
            }
            else {
                var_dump($add->errors);
            }
        }
    }

    public function down()
    {
        $this->delete($this->table, 'id is not null');
    }

}
