<?php

namespace App\Services;


use Illuminate\Support\Str;

class Helper
{

    public static function uniqueName(): ?string
    {
        return (string)Str::uuid();
    }

}
