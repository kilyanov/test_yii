<?php

declare(strict_types=1);

namespace api\modules\v1\records\order;

use OpenApi\Annotations as OA;
use common\models\Clients as ClientsModel;

/**
 * @OA\Schema(title="Заказ")
 */
class Client extends ClientsModel
{
    /**
     * @OA\Property(property="id", type="string", format="uuid", description="ID пользователя")
     * @OA\Property(property="fio", type="string", description="ФИО")
     * @OA\Property(property="company", type="string", description="Компания")
     */
    public function fields(): array
    {
        return [
            'id',
            'fio',
            'company',
        ];
    }

}
