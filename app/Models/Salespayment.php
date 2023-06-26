<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salespayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'branch_id',
        'sales_id',
        'customer_id',
        'date',
        'time',
        'oldblance',
        'amount',
        'payment_pending',
        'soft_delete'
    ];
}
