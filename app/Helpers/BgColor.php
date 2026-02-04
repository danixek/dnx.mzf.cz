<?php

namespace App\Helpers;

class BgColor
{
    protected static int $index = 0;

    public static function next(): string
    {
        $class = self::$index % 2 === 0
            ? 'bg-light-gray'
            : 'bg-dark-gray';

        self::$index++;
        return $class;
    }

    public static function reset(): void
    {
        self::$index = 0;
    }
}
?>