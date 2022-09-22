<?php

declare(strict_types=1);

namespace common\menu;

class UpdateItem extends BaseItem
{
    public string $label = 'Редактировать';
    protected string $action = 'update';
    public array $linkOptions = [
        'role' => 'modal-remote',
        'title' => 'Редактировать'
    ];

}
