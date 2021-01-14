<?php

namespace App\Repositories;

use App\Models\SystemParam;
use App\Repositories\Contracts\SystemParamInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SystemParamRepository implements SystemParamInterface
{
    public function index(int $page, int $perPage): LengthAwarePaginator
    {
        return SystemParam::paginate($perPage, ['*'], null, $page);
    }
}
