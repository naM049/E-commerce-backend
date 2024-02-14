<?php

namespace App\Enums;

enum OrderStatus: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case SHIPPING = 'shipping';
    case SHIPPED = 'shipped';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
