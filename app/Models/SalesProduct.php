<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'sales_id',
        'productlist_id',
        'bag',
        'kgs',
        'price_per_kg',
        'total_price',
        'status',
        'soft_delete'
    ];
}
