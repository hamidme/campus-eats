<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 🚨 THIS IS THE MAGIC PART 🚨
    // It automatically converts the database text into an Array
    protected $casts = [
        'items' => 'array',
    ];

    // Relationship: User who bought the food
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Vendor who sold the food
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}