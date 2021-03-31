<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface ProductInterface
{
    public function get($limit);
    public function all($paginate);
    public function getBySlug($slug);
}
