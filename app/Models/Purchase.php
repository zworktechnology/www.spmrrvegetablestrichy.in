<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'supplier_id',
        'date',
        'time',
        'branch_id',
        'grand_total',
        'paid_amount',
        'balance_amount',
        'bank_id',
        'bill_no',
        'extra_cost',
        'note',
        'total',
        'status',
        'soft_delete'
    ];


    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'supplier_id');
    }


    public function branch()
    {
        return $this->hasMany(Branch::class, 'branch_id');
    }
}
