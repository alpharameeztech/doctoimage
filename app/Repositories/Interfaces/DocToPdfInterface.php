<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface DocToPdfInterface
{
    public function execute($file);
}
