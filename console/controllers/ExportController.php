<?php

declare(strict_types=1);

namespace console\controllers;

use common\models\Clients;
use common\models\Orders;
use common\models\OrderToProducts;
use yii\console\Controller;

class ExportController extends Controller
{
    public function actionIndex()
    {
        $data = "ФИО;Компания;Общая сумма заказов\r\n";
        $clients = Clients::find()->orderBy('createdAt')->all();
        foreach ($clients as $client) {
            /** @var Clients $client */
            $orderIds = Orders::find()->select('id')->andWhere(['{{%orders}}.clientId' => $client->id]);
            $sum = (float)OrderToProducts::find()->joinWith(['product'])
                ->where(['{{%order_to_products}}.orderId' => $orderIds])
                ->sum('{{%order_to_products}}.countProduct * {{%products}}.price');
            $data .= $client->fio.
                ';' . $client->company .
                ';' . $sum .
                "\r\n";
        }
        $dir = \Yii::getAlias('@backend') .
            DIRECTORY_SEPARATOR . 'web' .
            DIRECTORY_SEPARATOR . 'export' . DIRECTORY_SEPARATOR;
        file_put_contents($dir . 'export.csv', $data);
    }

}
