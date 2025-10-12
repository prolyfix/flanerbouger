<?php

namespace App\Helper;

class StringHelper
{
    public static function generateUniqueId(): string
    {
        $bytes = random_bytes(20);
        return base64_encode($bytes);
    }
}
