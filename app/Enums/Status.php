<?php

namespace App\Enums;

enum Status: int {
    case PENDING = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;
}
