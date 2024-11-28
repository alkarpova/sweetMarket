<?php

namespace App\Enums;

enum ShippingMethod: string
{
    case Courier = 'courier';
    case Pickup = 'pickup';
}
