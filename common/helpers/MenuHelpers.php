<?php

declare(strict_types=1);

namespace common\helpers;

use Yii;
use common\menu\BaseActionMenu;
use backend\widgets\DropdownHelpers;

class MenuHelpers
{

    public static function actionMenu(array $params, string $controllerId = 'default', string $className = BaseActionMenu::class): string
    {
        $menu = new $className();
        $menu->setPartUrl($controllerId);
        $data = $menu->general($params);
        if (count($data) > 0) {
            return DropdownHelpers::general(['items' => $data]);
        }
    }

    public static function activeItemMainMenu(string $link): bool
    {
        return Yii::$app->request->url === $link;
    }

}
