<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Session;

class Home extends Component
{
    public $search = '';

    // This function runs when the user clicks "ADD +"
    public function addToCart($menuItemId)
    {
        // 1. Get the current cart from the "Backpack" (Session)
        $cart = Session::get('cart', []);

        // 2. If the item is already there, increase quantity. If not, add it.
        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity']++;
        } else {
            $item = MenuItem::find($menuItemId);
            $cart[$menuItemId] = [
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => 1,
                'image' => $item->image_path,

                // 🚨 THIS IS THE MISSING KEY 🚨
                'vendor_id' => $item->vendor_id,
            ];
        }

        // 3. Put the backpack back in the locker
        Session::put('cart', $cart);
        
        // 4. Send a browser alert (Temporary feedback)
        $this->js("alert('Added to cart!')"); 
    }

    public function render()
    {
        $menuItems = MenuItem::where('name', 'like', '%'.$this->search.'%')->get();

        return view('livewire.home', [
            'menuItems' => $menuItems,
            'cartCount' => count(Session::get('cart', [])), // Count different items
        ]);
    }
}