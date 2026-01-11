<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction; // Add this at the top

class WalletController extends Controller
{
    // 1. Show the Top Up Page
    public function showTopUp()
    {
        // Get logged-in user's transactions, newest first
        $transactions = Transaction::where('user_id', Auth::id())
                                ->latest()
                                ->get();

        return view('wallet.topup', compact('transactions'));
    }

    // 2. Process the Money (Add to Balance)
    public function processTopUp(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'receipt' => 'required|image|max:2048' // Max 2MB image
        ]);

        // 2. Handle File Upload
        if ($request->hasFile('receipt')) {
            // Save into 'storage/app/public/receipts'
            $path = $request->file('receipt')->store('receipts', 'public');
        }

        // 3. Create Transaction Record (Pending)
        Transaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'status' => 'pending', // IMPORTANT: Not approved yet!
            'type' => 'deposit',
            'proof_image' => $path ?? null
        ]);

        // 4. Do NOT add money yet. Just notify them.
        return redirect()->route('home')->with('success', 'Receipt submitted! We will verify it shortly.');
    }
}