<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ContactTopic: string implements HasLabel
{
    case Support = 'support';
    case Feedback = 'feedback';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Support => 'Support',
            self::Feedback => 'Feedback',
            self::Other => 'Other',
        };
    }
}
