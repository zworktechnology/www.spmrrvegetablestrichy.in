<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;


    protected $fillable = [
        'unique_key',
        'branch_id',
        'supplier_id',
        'date',
        'time',
        'amount',
        'soft_delete'
    ];
}
