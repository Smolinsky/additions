<?php

namespace App\Repositories;

use App\Models\FaqType;
use App\Repositories\Contracts\FaqTypeInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FaqTypeRepository implements FaqTypeInterface
{
    public function index(int $page, int $perPage, $with = []): LengthAwarePaginator
    {
        return FaqType::with($with)
            ->orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }
}
