<?php

declare(strict_types=1);

namespace backend\modules\user\services;

use backend\modules\user\search\UserSearch;
use common\models\User;
use common\services\BaseService;

class UserService extends BaseService
{
    protected string $modelClass = User::class;
    protected string $searchModelClass = UserSearch::class;
}
