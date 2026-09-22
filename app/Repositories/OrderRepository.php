<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function createItem(
        Order $order,
        array $data
    ): void {
        $order->items()->create($data);
    }

    public function findById(int $id): Order
    {
        return Order::with('items')
            ->findOrFail($id);
    }
}