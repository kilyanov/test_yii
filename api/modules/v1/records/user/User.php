<?php

declare(strict_types=1);

namespace api\modules\v1\records\user;

use common\rbac\CollectionRolls;
use OpenApi\Annotations as OA;
use Yii;
use common\models\User as UserModel;
use Carbon\Carbon;

/**
 * @OA\Schema(title="Пользователь")
 */
class User extends UserModel
{
    /**
     * @OA\Property(property="id", type="string", format="uuid", description="ID пользователя")
     * @OA\Property(property="username", type="string", description="Логин пользователя")
     * @OA\Property(property="email", type="string", description="Email пользователя")
     * @OA\Property(property="status", type="string", description="Статус пользователя")
     * @OA\Property(property="createdAt", type="string", description="Дата создания")
     * @OA\Property(property="updatedAt", type="string", description="Дата обновления")
     */
    public function fields(): array
    {
        return [
            'id',
            'username',
            'email',
            'status',
            'currentProfile',
            'createdAt' => function($model) {
                return Carbon::parse($model->createdAt, Yii::$app->timeZone)->toRfc3339String();
            },
            'updatedAt' => function($model) {
                return Carbon::parse($model->updatedAt, Yii::$app->timeZone)->toRfc3339String();
            },
        ];
    }

    public function extraFields(): array
    {
        return [
            'role',
        ];
    }


    public function getRole(): array
    {
        $listRoles = array_keys(Yii::$app->authManager->getRolesByUser($this->id));
        $result = [];
        foreach ($listRoles as $role) {
            $result[] = ['name' => $role, 'title' => CollectionRolls::getRoleName($role)];
        }

        return $result;
    }

}
