<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem; // Ensure you have this Model created!

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // 1. Start with the "Available" Rule
        // This ensures NO sold-out items ever sneak into the list.
        $query = MenuItem::where('is_available', true);

        // 2. Apply Search (if needed)
        if ($request->filled('search')) {
            $keyword = $request->search;
            
            // We group the OR logic inside a closure function($q)
            // SQL: WHERE is_available = 1 AND (name LIKE %...% OR description LIKE %...%)
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        // 3. Get results (Newest first looks better usually)
        $menuItems = $query->latest()->get();

        return view('index', compact('menuItems'));
    }
}