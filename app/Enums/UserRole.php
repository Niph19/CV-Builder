<?php

namespace App\Enums;

enum UserRole: string
{
    case Siswa = 'siswa';
    case Alumni = 'alumni';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Siswa => 'Siswa',
            self::Alumni => 'Alumni',
            self::Admin => 'Admin',
        };
    }

    /**
     * @return array<int, UserRole>
     */
    public static function selfRegisterable(): array
    {
        return [self::Siswa, self::Alumni];
    }

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }
}
