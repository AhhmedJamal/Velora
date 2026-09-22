<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function index()
    {
        $orders = Order::with('customer', 'orderItems.product')
            ->latest()
            ->paginate(15);

        return OrderResource::collection($orders);
    }


    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->create(
            $request->validated()
        );

        return new OrderResource($order);
    }
}
