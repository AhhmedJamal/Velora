<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function findById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function decreaseStock(
        Product $product,
        int $quantity
    ): void {
        $product->decrement('stock', $quantity);
    }
}