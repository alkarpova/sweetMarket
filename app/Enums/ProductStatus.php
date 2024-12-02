<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductStatus: int implements HasLabel
{
    case Draft = 0;
    case Pending = 1;
    case Rejected = 3;
    case Published = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending',
            self::Rejected => 'Rejected',
            self::Published => 'Published',
        };
    }
}
