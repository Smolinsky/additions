<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductInterface
{
    public function index(int $page, int $perPage, $with = []): LengthAwarePaginator
    {
        return Product::with($with)
            ->orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }

    /**
     * @param int|string $productId
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchByProductId($productId, int $page, int $perPage): LengthAwarePaginator
    {
        return Product::query()
            ->where('id', $productId)
            ->orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }

}
