<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductCategoryResource;
use App\Repositories\Contracts\ProductCategoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ProductCategoryController
 * @package App\Http\Controllers\Api
 */
class ProductCategoryController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, ProductCategoryInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = $this->repository->index($this->page, $this->perPage);

        return ProductCategoryResource::collection($categories);
    }

}
