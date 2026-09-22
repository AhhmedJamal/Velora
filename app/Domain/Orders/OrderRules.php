<?php

namespace App\Domain\Orders;

use App\Models\Order;
use DomainException;

class OrderRules
{
    public function canBeCancelled(Order $order): bool
    {
        return in_array($order->status, [
            OrderStatus::PENDING->value,
            OrderStatus::PROCESSING->value,
        ]);
    }

    public function validateCancellation(Order $order): void
    {
        if (! $this->canBeCancelled($order)) {
            throw new DomainException('لا يمكن إلغاء الطلب في هذه المرحلة');
        }
    }
}