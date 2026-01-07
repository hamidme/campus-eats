<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class MyOrders extends Component
{
    public function render()
    {
        // 1. Get the current logged-in user ID
        // (If testing as guest, this might return null, so we default to 1 for dev purposes if needed)
        $userId = Auth::id(); 

        // 2. Fetch orders for this user
        $orders = Order::where('user_id', $userId)
            ->with(['items', 'vendor']) // Load the related data eagerly
            ->latest() // Newest first
            ->get();

        return view('livewire.my-orders', [
            'orders' => $orders
        ]);
    }
}