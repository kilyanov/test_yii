<?php

declare(strict_types=1);

namespace backend\modules\products\services;

use backend\modules\products\search\ProductsSearch;
use common\models\Products;
use common\services\BaseService;

class ProductService extends BaseService
{
    protected string $modelClass = Products::class;
    protected string $searchModelClass = ProductsSearch::class;
}
