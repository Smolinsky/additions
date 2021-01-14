<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FaqInterface
{
    public function index(int $page, int $perPage, bool $is_show = null): LengthAwarePaginator;

    public function searchByTypeId($faqTypeId, int $page, int $perPage): LengthAwarePaginator;
}
