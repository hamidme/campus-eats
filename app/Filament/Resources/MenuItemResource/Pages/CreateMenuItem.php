<?php

namespace App\Filament\Resources\MenuItemResource\Pages;

use App\Filament\Resources\MenuItemResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification; // Import this for error alerts

class CreateMenuItem extends CreateRecord
{
    protected static string $resource = MenuItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Get the current user
        $user = Auth::user();

        // 2. If it's a Vendor, force the 'vendor_id' to be THEIR kitchen
        if ($user->role === 'vendor') {
            
            // Check if they actually have a kitchen assigned!
            if (!$user->vendor) {
                Notification::make()
                    ->title('Error')
                    ->body('You do not have a Kitchen assigned to your account yet. Please contact Admin.')
                    ->danger()
                    ->send();
                
                $this->halt(); // Stop the save process
            }

            $data['vendor_id'] = $user->vendor->id;
        }

        return $data;
    }
}