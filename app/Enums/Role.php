<?php

namespace App\Enums;

enum Role: int {
    case ADMIN = 1;
    case EMPLOYEE = 2;
    case CUSTOMER = 3;
}
