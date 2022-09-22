<?php

declare(strict_types=1);

namespace common\helpers;

use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

class ButtonsHelpers
{

    public static function createButton(bool $isAjax = true, array $url = ['create'], array $options = ['class' => 'btn btn-primary', 'role' => 'modal-remote']): string
    {
        if (!$isAjax) {
            $options = [
                'class' => 'btn btn-primary',
            ];
        }

        return Html::a('Добавить', $url, $options);
    }

    public static function resetButton(bool $isAjax = true, array $url = [''], array $options = ['class' => 'btn btn-default']): string
    {
        if (!$isAjax) {
            $options = [
                'class' => 'btn btn-default',
            ];
        }

        return Html::a('Сбросить фильтр', $url, $options);
    }

    public static function deleteAllButton(
        array $url = ['delete-all'],
        array $options = [
            'class' => 'btn btn-danger',
            'role' => 'modal-remote-bulk',
            'data-confirm' => false,
            'data-method' => false,
            'data-request-method' => 'post',
            'data-confirm-title' => 'Подтверждение удаления!',
            'data-confirm-message' => 'Вы уверены что хотите удалить выбранные записи?',
            'style' => 'margin-bottom:15px;margin-left:7px;'
        ]
    ): string
    {
        return Html::a('Удалить выбранные', $url, $options);
    }

    /**
     * @throws \Throwable
     */
    public static function createModel(string $id = 'ajaxCrudModal'): string
    {
        return Modal::widget([
            'closeButton' => false,
            'size' => 'modal-lg',
            'id' => $id,
            'footer' => '',
        ]);
    }

}
