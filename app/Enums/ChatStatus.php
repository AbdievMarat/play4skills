<?php

namespace App\Enums;

enum ChatStatus: string
{
    case Active = 'Прочитано';
    case Inactive = 'Не прочитано';

    public static function values(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
