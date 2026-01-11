<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class KitchenController extends Controller
{
    // 1. Show the Board
    public function index()
    {
        // Fetch active orders with their items and the user who ordered
        $orders = Order::whereIn('status', ['pending', 'cooking', 'ready'])
                       ->with(['orderItems', 'user'])
                       ->orderBy('id', 'asc') // Oldest first (FIFO - First In, First Out)
                       ->get();

        return view('kitchen.index', compact('orders'));
    }

    // 2. Chef updates status (e.g., Start Cooking -> Ready)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Simple state machine
        if ($request->status) {
            $order->status = $request->status;
            $order->save();
        }

        return back()->with('success', 'Order status updated!');
    }
}