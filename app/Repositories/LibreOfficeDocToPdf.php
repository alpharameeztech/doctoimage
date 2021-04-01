<?php

namespace App\Repositories;

use App\Advertisement;
use App\Models\Product;
use App\Repositories\Interfaces\AdvertisementRepositoryInterface;
use App\Repositories\Interfaces\DocToPdfInterface;

class LibreOfficeDocToPdf implements DocToPdfInterface
{

    public function execute($file)
    {
        //$results =  shell_exec(" libreoffice --headless --convert-to pdf /mnt/E/code/test/public/good.docx --outdir /mnt/E/code/test/public/");

        return shell_exec("libreoffice --headless --convert-to pdf good.docx ");
    }

}
