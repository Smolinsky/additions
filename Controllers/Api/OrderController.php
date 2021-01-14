<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Order\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Product;
use App\Repositories\Contracts\OrderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BasketController
 * @package App\Http\Controllers\Api
 */
class OrderController extends ApiBaseController
{
    protected $repository;

    public function __construct(Request $request, OrderInterface $repository)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * @param OrderRequest $request
     * @return OrderResource
     */
    public function index(OrderRequest $request): OrderResource
    {
        $sanitized = $request->getSanitized();

        $order = $this->repository->index($this->user->order, $sanitized);

        return new OrderResource($order);
    }

    /**
     * @param OrderRequest $request
     * @return OrderResource
     */
    public function orderConfirm(OrderRequest $request): OrderResource
    {
        $sanitized = $request->getSanitized();

        $sanitized['status'] = 1;

        $order = $this->repository->orderConfirm($this->user->order, $sanitized);

        return new OrderResource($order);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function basketAdd($id)
    {
        $productId = $this->getIdByUuid(Product::class, $id);

        $user_id = $this->user->id;

        $this->repository->basketAdd($user_id, $productId);

        return response()->json([
            'user_id' => $this->user->id,
            'product_id' => $id,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function basketRemove($id)
    {
        $productId = $this->getIdByUuid(Product::class, $id);

        $this->repository->basketRemove($productId);

        return response()->json([
            'user_id' => $this->user->id,
            'product_id' => $id,
        ]);
    }

}
