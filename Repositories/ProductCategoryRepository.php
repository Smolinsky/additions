<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\ProductCategoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductCategoryRepository implements ProductCategoryInterface
{
    public function index(int $page, int $perPage): LengthAwarePaginator
    {
        return Category::query()
            ->orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }

}
