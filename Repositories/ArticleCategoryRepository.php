<?php

namespace App\Repositories;

use App\Models\ArticleCategory;
use App\Repositories\Contracts\ArticleCategoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleCategoryRepository implements ArticleCategoryInterface
{
    public function index(int $page, int $perPage, $with = []): LengthAwarePaginator
    {
        return ArticleCategory::with($with)
            ->orderBy('order')
            ->paginate($perPage, ['*'], null, $page);
    }
}
