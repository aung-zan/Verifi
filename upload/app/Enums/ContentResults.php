<?php

namespace App\Enums;

enum ContentResults: int
{
    case TRUE = 0;
    case FALSE = 1;
    case MISLEADING = 2;
    case UNPROVEN = 3;
    case MIXTURE = 4;
    case SATIRE = 5;

    public static function getText(int $result): string
    {
        return match ($result) {
            self::TRUE->value => 'True',
            self::FALSE->value => 'False',
            self::MISLEADING->value => 'Misleading',
            self::UNPROVEN->value => 'Unproven',
            self::MIXTURE->value => 'Mixture',
            self::SATIRE->value => 'Satire',
        };
    }
}
