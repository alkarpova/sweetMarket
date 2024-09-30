<?php

namespace App\Enums;

enum ProductStatus: int
{
    case Draft = 0;
    case Pending = 1;
    case Approved = 2;
    case Rejected = 3;
    case Published = 4;
    case Archived = 5;
    case Inactive = 6;
}
