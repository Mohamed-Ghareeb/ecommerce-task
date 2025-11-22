<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OrderResource;
use App\Http\Resources\Api\V1\SingleOrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::with(['user'])->paginate());
    }

    public function show(Order $order)
    {
        return new SingleOrderResource($order->load(['items.product', 'user']));
    }
}
