<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'name',
        'description',
        'available_stockin_bag',
        'available_stockin_kilograms',
        'status',
        'soft_delete'
    ];
}
