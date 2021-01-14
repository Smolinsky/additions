<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FaqTypeInterface
{
    public function index(int $page, int $perPage, $with = []): LengthAwarePaginator;
}
