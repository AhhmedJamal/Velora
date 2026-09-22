<?php

namespace App\Services;

class PaymentService
{
    public function pay(float $amount): bool
    {
        // Payment Gateway
        // Stripe / Paymob / etc...

        return true;
    }
}