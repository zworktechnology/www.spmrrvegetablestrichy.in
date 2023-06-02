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
        'branch_id',
        'date',
        'time',
        'bill_no',
        'bank_id',
        'total_amount',
        'note',
        'extra_cost',
        'gross_amount',
        'old_balance',
        'grand_total',
        'paid_amount',
        'balance_amount',
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
