<?php

declare(strict_types=1);

use common\models\User;
use common\rbac\CollectionRolls;
use yii\db\Migration;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class m220921_111314_add_data_to_user_table extends Migration
{
    public const TABLE_NAME = 'user';

    private string $table = '{{%' . self::TABLE_NAME . '}}';

    private array $_listUser = [
        [
            'email' => 'lsd-7d@yandex.ru',
            'username' => 'alex',
            'status' => User::STATUS_ACTIVE,
            'role' => CollectionRolls::ROLE_SUPER_ADMIN,
        ],
        [
            'email' => 'test@yandex.ru',
            'username' => 'test',
            'status' => User::STATUS_ACTIVE,
            'role' => CollectionRolls::ROLE_USER,
        ],
        [
            'email' => 'test1@yandex.ru',
            'username' => 'test1',
            'status' => User::STATUS_ACTIVE,
            'role' => CollectionRolls::ROLE_USER,
        ],
    ];

    /**
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        foreach ($this->_listUser as $user) {
            $role = $user['role'];
            unset($user['role']);
            $user['auth_key'] = Yii::$app->security->generateRandomString();
            $user['password_hash'] = Yii::$app->security->generatePasswordHash($user['username']);
            $user['createdAt'] = Carbon::now()->toDateTimeString();
            $user['updatedAt'] = Carbon::now()->toDateTimeString();
            $user['id'] = Uuid::uuid4();
            $this->insert($this->table, $user);
            $auth->assign($auth->getRole($role), $user['id']);
            echo 'OK USER ID#' . $user['id'] . PHP_EOL;
        }
    }

    public function safeDown()
    {
        $this->delete($this->table, 'id is not null');
    }

}
