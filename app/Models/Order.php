<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = []; // Allows mass assignment

        public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship: An order belongs to a specific User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: An order belongs to a specific Vendor (Shop)
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}