<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductStatus: int implements HasLabel
{
    case Draft = 0;
    case Pending = 1;
    case Approved = 2;
    case Rejected = 3;
    case Published = 4;
    case Inactive = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Published => 'Published',
            self::Inactive => 'Inactive',
        };
    }
}
