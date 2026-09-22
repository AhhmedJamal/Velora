<?php

namespace App\Enums;

enum AccountRole: string
{
    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';
    case CUSTOMER = 'customer';
}