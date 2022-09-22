<?php

declare(strict_types=1);

use backend\assets\CrudAsset;
use common\helpers\ButtonsHelpers;
use common\helpers\MenuHelpers;
use common\models\Products;
use kartik\grid\ActionColumn;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

CrudAsset::register($this);

/**
 * @var ActiveQuery $model
 * @var ActiveDataProvider $dataProvider
 */

$this->title = 'Товар';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <?= ButtonsHelpers::createButton() ?>
                    <?= ButtonsHelpers::resetButton() ?>
                </div>
                <div class="card-body table-responsive p-0">
                    <?= GridView::widget([
                        'filterModel' => $model,
                        'dataProvider' => $dataProvider,
                        'pjax' => true,
                        'id' => 'crud-datatable',
                        'columns' => [
                            [
                                'class' => CheckboxColumn::class,
                                'width' => '20px',
                            ],
                            [
                                'width' => '50px',
                                'header' => '',
                                'class' => ActionColumn::class,
                                'mergeHeader' => true,
                                'template' => '{menu}',
                                'buttons' => [
                                    'menu' => function ($url, $model) {
                                        return MenuHelpers::actionMenu([$model->id]);
                                    },
                                ],
                                'visible' => true,
                            ],
                            'name',
                            'price',
                        ],
                    ]);
                    ?>
                    <?= ButtonsHelpers::deleteAllButton() ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?= ButtonsHelpers::createModel() ?>
