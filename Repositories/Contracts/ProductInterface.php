<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductInterface
{
    public function index(int $page, int $perPage, $with = []): LengthAwarePaginator;

    public function searchByProductId($productId, int $page, int $perPage): LengthAwarePaginator;

}
