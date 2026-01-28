<?php

namespace App\Enums;

enum Priority: int {
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;

    public static function labels(): array
    {
        return [
            self::LOW->value => 'Low',
            self::MEDIUM->value => 'Medium',
            self::HIGH->value => 'High',
        ];
    }
}
