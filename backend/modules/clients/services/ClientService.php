<?php

declare(strict_types=1);

namespace backend\modules\clients\services;

use backend\modules\clients\search\ClientsSearch;
use common\models\Clients;
use common\services\BaseService;

class ClientService extends BaseService
{
    protected string $modelClass = Clients::class;
    protected string $searchModelClass = ClientsSearch::class;
}
