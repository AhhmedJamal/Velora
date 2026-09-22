<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;

class OrderRepository
{
    public function findProduct(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }
}
