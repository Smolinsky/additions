<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Articles\ArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Models\ArticleCategory;
use App\Repositories\Contracts\ArticleInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ArticleController
 * @package App\Http\Controllers\Api
 */
class ArticleController extends ApiBaseController
{
    protected $allowsWith = ['category'];
    protected $repository;

    public function __construct(Request $request, ArticleInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @param ArticleIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(ArticleIndexRequest $request): AnonymousResourceCollection
    {
        $categorySlug = $request->get('category', '');
        $categoryId = $this->getIdByUuid(ArticleCategory::class, $categorySlug, 'slug');
        $articles = $this->repository->index($this->page, $this->perPage, $this->with, null, $categoryId);

        return ArticleResource::collection($articles);
    }

    /**
     * @param $slug
     * @return ArticleResource|JsonResponse
     */
    public function show($slug)
    {
        $article = $this->repository->show($slug, $this->with);

        if (!$article) {
            return $this->invalidate(trans('messages.article not found'));
        }

        return new ArticleResource($article);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getTopList(): AnonymousResourceCollection
    {
        $articles = $this->repository->index($this->page, $this->perPage, $this->with, true);

        return ArticleResource::collection($articles);
    }
}
