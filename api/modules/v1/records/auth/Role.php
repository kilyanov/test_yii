<?php

declare(strict_types=1);

namespace app\modules\v1\records\auth;

use yii\base\Model;

/**
 * @OA\Schema(title="Объект роли")
 */

class Role extends Model
{

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Системное имя типа профиля",
     *     title="name",
     * )
     */
    public string $name;


    /**
     * @OA\Property(
     *     property="value",
     *     type="string",
     *     description="Имя типа профиля",
     *     title="value",
     * )
     */
    public string $value;
}