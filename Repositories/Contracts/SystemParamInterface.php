<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SystemParamInterface
{
    public function index(int $page, int $perPage): LengthAwarePaginator;
}
