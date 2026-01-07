<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Vendor;
use App\Models\MenuItem;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // 1. Create a Vendor User
    $user = User::create([
        'name' => 'Mama Sarah',
        'email' => 'sarah@example.com',
        'password' => bcrypt('password'),
        'role' => 'vendor',
        'phone' => '601122334455'
    ]);

    // 2. Create the Vendor Profile
    $vendor = Vendor::create([
        'user_id' => $user->id,
        'kitchen_name' => "Mama Sarah's Kitchen",
        'location_details' => 'Mahallah Ali, Block B',
        'is_open' => true,
    ]);

    // 3. Create Menu Items
    MenuItem::create([
        'vendor_id' => $vendor->id,
        'name' => 'Smoky Jollof Rice',
        'description' => 'Served with fried plantain and beef.',
        'price' => 12.00,
        'image_path' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=300'
    ]);

    MenuItem::create([
        'vendor_id' => $vendor->id,
        'name' => 'Egusi Soup & Pounded Yam',
        'description' => 'Authentic melon seed soup with beef.',
        'price' => 18.00,
        'image_path' => 'https://images.unsplash.com/photo-1543340904-991f3751a30f?w=300'
    ]);
}
}
