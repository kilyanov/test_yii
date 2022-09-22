<?php

declare(strict_types=1);

namespace api\modules\v1\records\auth;

use common\models\UserToken as UserTokenModel;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Токены пользователя")
 */
class UserToken extends UserTokenModel
{
    /**
     * @OA\Property(property="token", type="string", description="Токен")
     * @OA\Property(property="expiredAt", type="string", description="Время жизни токена")
     */
    public function fields(): array
    {
        return [
            'token',
            'expiredAt' => $this->getDateValue('expiredAt'),
        ];
    }
}