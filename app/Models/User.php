<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser; // <--- MAKE SURE THIS IS IMPORTED
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// 1. ADD "implements FilamentUser"
class User extends Authenticatable implements FilamentUser 
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 2. THIS IS THE SECURITY GATE
    public function canAccessPanel(Panel $panel): bool
    {
        // Only Admin and Vendor can enter.
        // Students return FALSE (Access Denied).
        return $this->role === 'admin' || $this->role === 'vendor';
    }
    
    // Relationship for Vendor
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
}