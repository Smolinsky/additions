<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface OrderInterface
{
    public function index(Order $order, array $attributes): Order;

    public function basketAdd($user_id, $productId);

    public function basketRemove($productId);

    public function orderConfirm(Order $order, array $attributes): Order;

}
