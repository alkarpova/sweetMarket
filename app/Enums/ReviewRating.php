<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReviewRating: int implements HasLabel
{
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::One => '1 Stars',
            self::Two => '2 Stars',
            self::Three => '3 Stars',
            self::Four => '4 Stars',
            self::Five => '5 Stars',
        };
    }
}
