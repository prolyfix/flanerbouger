<?php

namespace App\Helper;

class StringHelper
{
    public static function generateUniqueId(): string
    {
        $bytes = random_bytes(20);
        return base64_encode($bytes);
    }

    public static function retrieveMonth(int $monthNumber): string
    {
        $months = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre',
        ];

        return $months[$monthNumber] ?? 'Invalid month';
    }
}
