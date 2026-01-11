<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // REVERT TO THIS:
        $userId = Auth::id(); // Get the REAL logged-in ID

        // If user is not logged in, redirect to login page (Safety check)
        if (!$userId) {
            return redirect()->route('login');
        }

        $orders = Order::where('user_id', $userId)
                    ->with('vendor') 
                    ->latest()
                    ->get();

        return view('orders', compact('orders'));
    }
}