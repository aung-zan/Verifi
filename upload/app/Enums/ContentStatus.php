<?php

namespace App\Enums;

enum ContentStatus: int
{
    case IN_PROGRESS = 0;
    case SUCCESS = 1;
    case FAIL = 2;

    public static function getText(int $status): string
    {
        return match ($status) {
            self::IN_PROGRESS->value => 'in-progress',
            self::SUCCESS->value => 'success',
            self::FAIL->value => 'fail'
        };
    }
}
