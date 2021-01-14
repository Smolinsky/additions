<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\Contracts\UnitInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UnitRepository implements UnitInterface
{
    public function index(int $page, int $perPage): LengthAwarePaginator
    {
        return Unit::orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }
}
