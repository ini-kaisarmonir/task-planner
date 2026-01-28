<?php

namespace App\Enums;

enum Status: int {
    case PENDING = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::IN_PROGRESS->value => 'In Progress',
            self::COMPLETED->value => 'Completed',
        ];
    }
}
