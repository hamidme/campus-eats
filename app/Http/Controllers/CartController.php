<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem; // CHECK THIS: Is your model named 'MenuItem', 'Food', or 'Product'?
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\MenuVariant;

class CartController extends Controller
{
    // 1. ADD TO CART
    public function addToCart($id)
    {
        $product = MenuItem::findOrFail($id); // Make sure 'MenuItem' matches your actual Model name

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_path
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Added to cart!');
    }

    public function addVariant(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:menu_variants,id',
        ]);

        $variant = MenuVariant::with('menuItem')->findOrFail($request->variant_id);
        $cart = session()->get('cart', []);

        // We use a unique key for the cart: "variant_ID"
        // This ensures "Small Rice" and "Large Rice" are treated as different items
        $cartKey = 'variant_' . $variant->id;

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = [
                "name" => $variant->menuItem->name . " (" . $variant->name . ")",
                "quantity" => 1,
                "price" => $variant->price,
                "image" => $variant->menuItem->image_path, // Use parent's image
                "id" => $variant->id,
                "type" => "variant" // Helper tag for later
            ];
        }

        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Added to cart successfully!');
    }

    // 2. VIEW CART (This was missing!)
    public function index()
    {
        $cartItems = session()->get('cart', []);
        return view('cart.index', compact('cartItems'));
    }

    // 3. CHECKOUT
    public function checkout()
    {
        $cart = session()->get('cart');
        if(!$cart) return redirect()->back()->with('error', 'Cart is empty!');

        $totalAmount = 0;
        foreach($cart as $details) {
            $totalAmount += $details['price'] * $details['quantity'];
        }

        $user = User::find(Auth::id());

        if($user->wallet_balance < $totalAmount) {
            return redirect()->back()->with('error', 'Insufficient balance!');
        }

        DB::transaction(function() use ($user, $totalAmount, $cart) {
            // 1. Deduct Money
            $user->wallet_balance -= $totalAmount;
            $user->save();

            // 2. Create the Main Order
            $order = Order::create([
                'user_id' => $user->id,
                'vendor_id' => 1, 
                'total_amount' => $totalAmount,
                'status' => 'pending' // Pending Kitchen Action
            ]);

            // 3. SAVE THE ITEMS (The Missing Part!)
            foreach($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $id,
                    'menu_name'      => $details['name'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }

            // 4. Clear Cart
            session()->forget('cart');
        });

        return redirect()->route('orders')->with('success', 'Order placed successfully!');
    }

    // 4. REMOVE ITEM
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]); // Delete the item
            session()->put('cart', $cart); // Save the new cart
        }

        return redirect()->back()->with('success', 'Item removed from tray!');
    }
}