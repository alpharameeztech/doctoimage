<?php

namespace App\Repositories;

use App\Advertisement;
use App\Repositories\Interfaces\AdvertisementRepositoryInterface;
use App\Repositories\Interfaces\ZipFilesInterface;

class Zip implements ZipFilesInterface
{

    public function execute($files)
    {
        return shell_exec("zip default.zip *");
    }

}
