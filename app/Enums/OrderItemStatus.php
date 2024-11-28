<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OrderItemStatus: string implements HasLabel
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Refunded = 'refunded';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Processing => 'Processing',
            self::Completed => 'Completed',
            self::Canceled => 'Canceled',
            self::Refunded => 'Refunded',
        };
    }
}
