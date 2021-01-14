<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderInterface;
use Auth;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository implements OrderInterface
{

    public function index(Order $order, array $attributes): Order
    {
        $order->load($attributes);

        return $order;
    }

    /**
     * @param $user_id
     * @param int|string $productId
     * @return void
     */

    public function basketAdd($user_id, $productId)
    {
        $orderId = Auth::user()->order;

        if (is_null($orderId)) {
            $order = Order::create(['user_id' => $user_id]);
        } else {
            $order = Order::find($orderId->id);
        }

        if ($order->products->contains($productId)) {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            $pivotRow->quantity++;
            $pivotRow->update();
        } else {
            $order->products()->attach($productId);
        }
    }

    /**
     * @param int|string $productId
     * @return Builder
     */

    public function basketRemove($productId)
    {
        $orderId = Auth::user()->order;

        $order = Order::find($orderId->id);

        if ($order->products->contains($productId)) {
            $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
            if ($pivotRow->quantity < 2) {
                $order->products()->detach($productId);
            } else {
                $pivotRow->quantity--;
                $pivotRow->update();
            }
        }
    }

    public function orderConfirm(Order $order, array $attributes): Order
    {
        $order->update($attributes);

        return $order;
    }
}
