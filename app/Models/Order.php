<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 🚨 ADD THIS BLOCK 🚨
    protected $casts = [
        'items' => 'array', // <--- This fixes the "foreach" error
    ];

    // An order belongs to a Customer (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order belongs to a Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}