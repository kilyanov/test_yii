<?php

declare(strict_types=1);

use common\models\Clients;
use yii\db\Migration;

class m220921_123658_add_data_to_clients_table extends Migration
{
    public const TABLE_NAME = 'clients';

    private string $table = '{{%' . self::TABLE_NAME . '}}';

    public function safeUp()
    {
        for ($i = 1; $i < 1000; $i++) {
            $add = new Clients([
                'fio' => 'test ' . $i,
                'company' => 'name ' . $i,
            ]);
            $add->save();
            echo 'OK ADD Clients ID ' . $add->id . PHP_EOL;
        }
    }

    public function safeDown()
    {
        $this->delete($this->table, 'id is not null');
    }

}
