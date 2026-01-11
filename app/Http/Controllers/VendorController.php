<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class VendorController extends Controller
{
    // 1. Show the Menu Manager Page
    public function myMenu()
    {
        // Fetch all items (Newest first)
        $items = MenuItem::latest()->get();
        
        return view('vendor.menu', compact('items'));
    }

    // 2. The Toggle Switch Logic
    public function toggle($id)
    {
        $item = MenuItem::findOrFail($id);
        
        // Flip the boolean (True becomes False, False becomes True)
        $item->is_available = !$item->is_available;
        $item->save();

        $status = $item->is_available ? 'In Stock 🟢' : 'Sold Out 🔴';
        
        return back()->with('success', "Item is now $status");
    }
}
