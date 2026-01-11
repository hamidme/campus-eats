<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vendor;

class MenuItem extends Model
{
    use HasFactory;

    // --- ADD THIS LINE ---
    protected $guarded = []; 
    // ---------------------

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    // A food item has many size options
    public function variants()
    {
        return $this->hasMany(MenuVariant::class);
    }
}