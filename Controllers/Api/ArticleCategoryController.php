<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ArticleCategoryResource;
use App\Repositories\Contracts\ArticleCategoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ArticleCategoryController
 * @package App\Http\Controllers\Api
 */
class ArticleCategoryController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, ArticleCategoryInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $articleCategories = $this->repository->index($this->page, $this->perPage, $this->with);

        return ArticleCategoryResource::collection($articleCategories);
    }
}
