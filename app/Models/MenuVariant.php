<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'name',
        'price',
        'capacity_info',
        'is_available'
    ];

    // Link back to the parent food
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}