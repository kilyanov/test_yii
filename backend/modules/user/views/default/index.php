<?php

declare(strict_types=1);

use common\helpers\ButtonsHelpers;
use common\models\User;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;


/**
 * @var ActiveQuery $model
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Пользователи';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <?= ButtonsHelpers::resetButton() ?>
                </div>
                <div class="card-body table-responsive p-0">
                    <?= GridView::widget([
                        'filterModel' => $model,
                        'dataProvider' => $dataProvider,
                        'pjax' => true,
                        'id' => 'crud-datatable',
                        'columns' => [
                            'username',
                            'email',
                            [
                                'attribute' => 'status',
                                'vAlign' => 'middle',
                                'value' => function($model) {
                                    return $model->getStatusValue();
                                },
                                'filter' => User::getStatusList()
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

