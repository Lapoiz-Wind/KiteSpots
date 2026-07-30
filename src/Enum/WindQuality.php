<?php

namespace App\Enum;

enum WindQuality: int
{
    case KO = -1;
    case WARN = 0;
    case OK = 1;
    case TOP = 2;

    public function label(): string
    {
        return match ($this) {
            self::KO => 'À éviter',
            self::WARN => 'Moyen',
            self::OK => 'Bon',
            self::TOP => 'Excellent',
        };
    }

    /** Couleur utilisée pour colorer la rose des vents. */
    public function color(): string
    {
        return match ($this) {
            self::KO => '#dc3545',
            self::WARN => '#fd7e14',
            self::OK => '#0d6efd',
            self::TOP => '#198754',
        };
    }
}
