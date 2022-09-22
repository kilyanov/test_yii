<?php

declare(strict_types=1);

namespace backend\modules\orders\services;

use backend\modules\orders\search\OrdersSearch;
use common\models\Orders;
use common\services\BaseService;

class OrderService extends BaseService
{
    protected string $modelClass = Orders::class;
    protected string $searchModelClass = OrdersSearch::class;
}
