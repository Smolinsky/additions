<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Contracts\ArticleInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleInterface
{
    public function index(int $page, int $perPage, $with = [], bool $isShow = null, $categoryId = null): LengthAwarePaginator
    {
        $query = Article::with($with);

        if (!is_null($isShow)) {
            $query->where('is_show', $isShow);
        }

        if (!is_null($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        return $query
            ->orderBy('published_at')
            ->paginate($perPage, ['*'], null, $page);
    }

    public function show($slug, $with = []): ?Article
    {
        return Article::where('slug', $slug)->with($with)->first();
    }
}
