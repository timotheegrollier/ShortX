<?php

namespace App\Utilis;

class Str
{
    public static function random($length = 6):string
    {
        return
        substr(bin2hex(random_bytes(32)), 0, $length);
    }
}
