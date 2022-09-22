<?php

declare(strict_types=1);

use common\models\Products;
use yii\bootstrap4\ActiveForm;

/**
 * @var $model Products
 **/

?>
<?php
$form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form
            ->field($model, 'fio') ?>
    </div>
    <div class="col-md-6">
        <?= $form
            ->field($model, 'company') ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
