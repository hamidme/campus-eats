<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\MenuVariant;

class MigratePricesToVariantsSeeder extends Seeder
{
    public function run()
    {
        $items = MenuItem::all();
        $count = 0;

        foreach ($items as $item) {
            // Check if this item already has variants to avoid duplicates
            if ($item->variants()->count() == 0) {
                
                MenuVariant::create([
                    'menu_item_id' => $item->id,
                    'name'         => 'Standard Plate', // Default name
                    'price'        => $item->price,     // Copy the old price
                    'capacity_info'=> 'Individual Meal',
                    'is_available' => $item->is_available ?? true,
                ]);
                
                $count++;
            }
        }

        $this->command->info("Success! Converted $count items into variants.");
    }
}