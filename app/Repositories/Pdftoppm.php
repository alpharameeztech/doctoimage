<?php

namespace App\Repositories;

use App\Advertisement;
use App\Repositories\Interfaces\PdfToImageInterface;

class Pdftoppm implements PdfToImageInterface
{

    public function execute($file)
    {
        return  $result = shell_exec("pdftoppm good.pdf good -jpeg");
    }

}
