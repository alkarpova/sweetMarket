<?php

namespace App\Enums;

enum UserRole: int
{
    case Admin = 1;
    case Client = 2;
    case Supplier = 3;
}
