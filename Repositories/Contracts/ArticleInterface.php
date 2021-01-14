<?php

namespace App\Repositories\Contracts;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleInterface
{
    public function index(int $page, int $perPage, $with = [], bool $isShow = null, $categoryId = null): LengthAwarePaginator;

    public function show($slug, $with = []): ?Article;
}
