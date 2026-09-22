<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function findById(int $id): Customer
    {
        return Customer::findOrFail($id);
    }
}