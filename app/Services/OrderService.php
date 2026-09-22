<?php

namespace App\Services;

use App\Domain\Orders\OrderStatus;
use App\Events\OrderCreated;
use App\Models\Order;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepository $orders,
        private ProductRepository $products,
        private CustomerRepository $customers,
        private ProductService $productService,
        private PaymentService $paymentService,
    ) {}

    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {

            // 1. Get customer
            $customer = $this->customers->findById(
                $data['customer_id']
            );

            $total = 0;

            $products = [];

            // 2. Get products + validate stock
            foreach ($data['items'] as $item) {

                $product = $this->products->findById(
                    $item['product_id']
                );

                $this->productService
                    ->validateAndDecreaseStock(
                        $product,
                        $item['quantity']
                    );

                $itemTotal =
                    $product->price *
                    $item['quantity'];

                $total += $itemTotal;

                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ];
            }

            // 3. Payment
            $this->paymentService->pay($total);

            // 4. Create order
            $order = $this->orders->create([
                'customer_id' => $customer->id,
                'total_price' => $total,
                'status' => OrderStatus::PENDING->value,
            ]);

            // 5. Create items
            foreach ($products as $item) {

                $this->orders->createItem(
                    $order,
                    [
                        'product_id' =>
                            $item['product']->id,

                        'product_name' =>
                            $item['product']->name,

                        'quantity' =>
                            $item['quantity'],

                        'price' =>
                            $item['product']->price,

                        'total' =>
                            $item['total'],
                    ]
                );
            }

            // 6. Event
            event(new OrderCreated($order));

            return $order->load('items');
        });
    }
}