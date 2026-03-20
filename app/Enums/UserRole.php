<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin   = 'super_admin';
    case User         = 'user';
    case ProductAdmin = 'product_admin';
    case SalesAdmin   = 'sales_admin';
}
