<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepository $orders,
    ) {
    }

    public function create(array $data): Order
    {
        $product = $this->orders->findProduct(
            $data['product_id']
        );

        $total = $product->price * $data['quantity'];

        return DB::transaction(function () use ($data, $total) {

            return $this->orders->create([
                'customer_id' => $data['customer_id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'total_price' => $total,
                'status' => 'pending',
            ]);
        });
    }
}