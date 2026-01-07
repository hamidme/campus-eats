<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Order;

class Cart extends Component
{
    public $cartItems = [];
    public $groupedItems = [];
    public $total = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Session::get('cart', []);
        $this->groupItemsByVendor();
    }

    public function groupItemsByVendor()
    {
        $this->groupedItems = [];
        $this->total = 0;

        foreach($this->cartItems as $id => $item) {
            // Default to 1 if missing, but usually vendor_id should be there
            $vendorId = $item['vendor_id'] ?? 1; 
            
            $this->groupedItems[$vendorId]['items'][$id] = $item;
            $this->total += $item['price'] * $item['quantity'];
        }

        // Fetch Vendor Names & Phones
        $vendorIds = array_keys($this->groupedItems);
        $vendors = Vendor::with('user')->whereIn('id', $vendorIds)->get();

        foreach($vendors as $vendor) {
            if(isset($this->groupedItems[$vendor->id])) {
                $this->groupedItems[$vendor->id]['name'] = $vendor->kitchen_name;
                $this->groupedItems[$vendor->id]['phone'] = $vendor->user->phone ?? '60111111111'; 
            }
        }
    }

    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
        }
        
        $this->loadCart();
    }
    
    // --- THE FIXED CHECKOUT FUNCTION ---
    public function checkout($vendorId)
    {
        // 1. Check Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Find the Vendor
        $vendor = Vendor::find($vendorId);
        if (!$vendor) {
            session()->flash('error', 'Vendor not found.');
            return;
        }

        // 3. Get items ONLY for this vendor using YOUR structure
        // We look inside 'groupedItems', not 'cart'
        if (!isset($this->groupedItems[$vendorId]['items'])) {
            return;
        }
        $itemsToOrder = $this->groupedItems[$vendorId]['items'];

        // Calculate total
        $total = collect($itemsToOrder)->sum(fn($item) => $item['price'] * $item['quantity']);

        // 4. Create Order
        $order = Order::create([
            'user_id' => Auth::id(),
            'vendor_id' => $vendorId, 
            'total_amount' => $total,
            'status' => 'pending',
            'items' => json_encode($itemsToOrder), 
        ]);

        // 5. Clean up Session (Remove ONLY these items from the main cart)
        $fullCart = Session::get('cart', []);
        
        foreach ($itemsToOrder as $itemId => $val) {
            // Remove the item from the session array
            unset($fullCart[$itemId]);
        }
        
        // Save the cleaned cart back to session
        Session::put('cart', $fullCart);
        
        // Reload local view to reflect changes
        $this->loadCart();

        // 6. WhatsApp Redirect
        $phone = $vendor->user->phone ?? '60111111111'; 
        
        $message = "Hello " . $vendor->kitchen_name . ", I would like to place an order:%0a";
        foreach ($itemsToOrder as $item) {
            $message .= "- " . $item['name'] . " (x" . $item['quantity'] . ")%0a";
        }
        $message .= "%0aTotal: RM" . $total;
        $message .= "%0aOrder ID: #" . $order->id;

        return redirect()->away("https://wa.me/{$phone}?text={$message}");
    }

    public function render()
    {
        return view('livewire.cart');
    }
}