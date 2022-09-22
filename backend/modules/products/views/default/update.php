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
    <div class="col-md-4">
        <?= $form
            ->field($model, 'name') ?>
    </div>
    <div class="col-md-4">
        <?= $form
            ->field($model, 'price') ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
