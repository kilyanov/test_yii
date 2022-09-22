<?php

declare(strict_types=1);

namespace common\rbac;

class CollectionRolls
{

    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_USER = 'user';

    public static function getListRole(): array
    {
        return [
            self::ROLE_SUPER_ADMIN => 'Суперадминистратор',
            self::ROLE_USER => 'Пользователь',
        ];
    }

    public static function getRoleName(string $role): string
    {
        $list = self::getListRole();

        return $list[$role];
    }

}
