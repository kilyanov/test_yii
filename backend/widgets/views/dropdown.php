<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 10.10.2017
 * Time: 15:33
 */

use yii\bootstrap4\Dropdown;
use yii\bootstrap4\Html;

/**
 * @var array $items
 */
?>

<div class="dropdown">
<?= Html::a('<i class="fas fa-th mr-1"></i>',
    '#',
    [
        'data-toggle' => 'dropdown',
        'class' => 'btn btn-default dropdown-toggle action ',
        'aria-expanded' => true
    ]
)?>

<?= Dropdown::widget([
    'items' => $items
]) ?>
</div>
