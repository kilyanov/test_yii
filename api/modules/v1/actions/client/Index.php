<?php
declare(strict_types=1);

namespace api\modules\v1\actions\client;

use api\modules\v1\search\ClientSearch;
use api\modules\v1\search\OrdersSearch;
use OpenApi\Annotations as OA;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\Action;

/**
 * @OA\Get(
 *     path="/v1/client",
 *     tags={"Client"},
 *     summary="Получение списка клиентов",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *       name="page",
 *       in="query",
 *       description="Номер страницы",
 *       required=false,
 *       @OA\Schema(
 *         type="integer"
 *      )
 *    ),
 *     @OA\Parameter(
 *       name="per-page",
 *       in="query",
 *       description="Кол-во элементов на странице",
 *       required=false,
 *       @OA\Schema(
 *         type="integer"
 *      )
 *    ),
 *   @OA\Response(
 *     response="200",
 *     description="Массив объектов клиентов",
 *     @OA\JsonContent(
 *       type="array",
 *       @OA\Items(ref="#/components/schemas/Client")
 *     )
 *   )
 * )
 */
class Index extends Action
{

    /**
     * @throws InvalidConfigException
     */
    public function run()
    {
        $search = new ClientSearch();
        return $search->search(Yii::$app->request->getQueryParams());
    }

}
