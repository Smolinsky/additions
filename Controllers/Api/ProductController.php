<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Contracts\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Api
 */
class ProductController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, ProductInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $products = $this->repository->index($this->page, $this->perPage, ['category']);

        return ProductResource::collection($products);
    }

    /**
     * @param $id
     * @return AnonymousResourceCollection
     */
    public function show($id): AnonymousResourceCollection
    {
        $productId = $this->getIdByUuid(Product::class, $id);
        $product = $this->repository->searchByProductId($productId, $this->page, $this->perPage);

        return ProductResource::collection($product);
    }

}
