<?php

namespace App\Enums;

enum UserRoles: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';

    public static function getRoles(): array
    {
        $roles = [];
        foreach (self::cases() as $role) {
            $roles[] = $role->value;
        }
        return $roles;
    }

    public static function getRolesExcept(array $exclude = []): array
    {
        $roles = [];
        foreach (self::cases() as $role) {
            if (!in_array($role->value, $exclude)) {
                $roles[] = $role->value;
            }
        }
        return $roles;
    }
}
