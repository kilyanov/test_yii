<?php
declare(strict_types=1);

namespace api\modules\v1\actions\order;

use api\modules\v1\search\OrdersSearch;
use OpenApi\Annotations as OA;
use Yii;
use yii\base\InvalidConfigException;
use yii\rest\Action;

/**
 * @OA\Get(
 *     path="/v1/order/{client}",
 *     tags={"Order"},
 *     summary="Получение списка заказов пользователя",
 *     security={{"BearerAuth": {}}},
 *     @OA\Parameter(
 *      name="client",
 *      in="path",
 *      description="id клиента",
 *      required=true,
 *      @OA\Schema(
 *        type="string",
 *        format="uuid"
 *      )
 *      ),
 *     @OA\Parameter(
 *       name="expand",
 *       in="query",
 *       description="дополнительные поля (client)",
 *       required=false,
 *       @OA\Schema(
 *         type="string"
 *      )
 *    ),
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
 *     description="Массив объектов заказов",
 *     @OA\JsonContent(
 *       type="array",
 *       @OA\Items(ref="#/components/schemas/Order")
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
        $client = Yii::$app->request->getQueryParam('client');
        $search = new OrdersSearch();
        return $search->search($client, Yii::$app->request->getQueryParams());
    }

}
