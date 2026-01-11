<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem; // Don't forget this!

class HomeController extends Controller
{
    public function index()
    {
        // 1. Fetch Items that are Available
        // 2. "with('variants')" grabs the size options efficiently
        $menuItems = MenuItem::where('is_available', true)
                             ->with('variants') 
                             ->latest()
                             ->get();
        
        return view('index', compact('menuItems'));
    }
}