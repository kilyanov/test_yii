<?php

namespace backend\widgets;

use Yii;

class DropdownHelpers
{

    public static function general(array $data = [], $title = null): string
    {
        if (empty($data)) return '';
        return Yii::$app->getView()->renderFile(
            '@app/widgets/views/dropdown.php',
            [
                'title' => (is_null($title)) ? '<i class="fa fa-wrench"></i>' : $title,
                'items' => $data['items']
            ]
        );
    }

}