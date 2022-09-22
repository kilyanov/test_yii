<?php

declare(strict_types=1);

namespace common\menu;

class DeleteItem extends BaseItem
{
    public string $label = 'Удалить';
    protected string $action = 'delete';
    public array $linkOptions = [
        'role' => 'modal-remote',
        'title' => 'Удалить',
        'data-confirm' => false,
        'data-method' => false,
        'data-request-method' => 'post',
        'data-confirm-title' => 'Подтверждение удаления!',
        'data-confirm-message' => 'Вы уверены что хотите удалить запись?'
    ];

}
