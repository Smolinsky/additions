<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductCategoryInterface
{
    public function index(int $page, int $perPage): LengthAwarePaginator;

}
