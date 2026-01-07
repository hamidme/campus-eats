<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    // refresh stats every 15 seconds so vendors see new orders quickly
    protected static ?string $pollingInterval = '15s'; 

    protected function getStats(): array
    {
        $user = auth()->user();
        
        // Start the query
        $query = Order::query();

        // STRICT FILTERING
        // We use 'strtolower' to ignore case sensitivity (Vendor vs vendor)
        if (strtolower($user->role) === 'vendor') {
            
            // If the user is a vendor but has no kitchen assigned, show ZERO.
            if (!$user->vendor) {
                return [
                    Stat::make('Error', 'No Kitchen Found')
                        ->description('Contact Admin')
                        ->color('danger'),
                ];
            }
            
            // Apply the filter: ONLY show orders for this vendor
            $query->where('vendor_id', $user->vendor->id);
        }

        // Now calculate stats based on the filtered query
        $totalOrders = $query->count();
        $pendingOrders = $query->clone()->where('status', 'pending')->count();
        $revenue = $query->clone()->sum('total_amount');

        return [
            Stat::make('Total Orders', $totalOrders)
                ->color('success'),
            Stat::make('Pending Orders', $pendingOrders)
                ->color($pendingOrders > 0 ? 'danger' : 'success'),
            Stat::make('Total Revenue', 'RM ' . number_format($revenue, 2))
                ->color('primary'),
        ];
    }
}