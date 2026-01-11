<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // This whitelist allows these fields to be saved via ::create()
    protected $fillable = [
        'user_id',
        'amount',
        'status',      // pending, approved, rejected
        'type',        // deposit, payment
        'proof_image'  // path to receipt
    ];

    // Helper: Link transaction to the User who made it
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}