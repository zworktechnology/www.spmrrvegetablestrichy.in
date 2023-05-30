<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_key',
        'name',
        'shop_name',
        'address',
        'contact_number',
        'mail_address',
        'web_address',
        'gst_number',
        'logo',
        'status'
    ];
}
