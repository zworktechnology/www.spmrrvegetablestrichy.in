<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'name',
        'contact_number',
        'email_address',
        'shop_name',
        'shop_address',
        'shop_contact_number',
        'status',
        'soft_delete'
    ];

    public function salespayment()
    {
        return $this->hasMany(Salespayment::class, 'customer_id');
    }
}
