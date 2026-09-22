<?php

namespace App\Services;

use App\Domain\Products\ProductRules;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $products,
        private ProductRules $rules,
    ) {}

    public function validateAndDecreaseStock(
        Product $product,
        int $quantity
    ): void {
        $this->rules->validateStock(
            $product,
            $quantity
        );

        $this->products->decreaseStock(
            $product,
            $quantity
        );
    }
}