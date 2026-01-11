<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get past orders with their items
        $orders = Order::where('user_id', $user->id)
                       ->with('orderItems')
                       ->latest() // Newest first
                       ->take(10) // Limit to last 10
                       ->get();

        return view('profile', compact('user', 'orders'));
    }
}