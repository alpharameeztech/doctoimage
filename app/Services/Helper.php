<?php

namespace App\Services;


use Illuminate\Support\Str;

class Helper
{

    public static function createUniqueDir(): ?string
    {
        $name = (string)Str::uuid();
        shell_exec("mkdir $name");
        return $name;
    }

}
