<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'purchase_id',
        'product_id',
        'bag',
        'kgs',
        'price_per_kg',
        'total_price',
        'status',
        'soft_delete'
    ];


    public function product()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}
