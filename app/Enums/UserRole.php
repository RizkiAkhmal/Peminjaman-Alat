<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Petugas = 'petugas';
    case Peminjam = 'peminjam';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Petugas => 'Petugas',
            self::Peminjam => 'Peminjam',
        };
    }

    public function dashboardRouteName(): string
    {
        return match ($this) {
            self::Admin => 'admin.dashboard',
            self::Petugas => 'petugas.dashboard',
            self::Peminjam => 'peminjam.dashboard',
        };
    }
}
