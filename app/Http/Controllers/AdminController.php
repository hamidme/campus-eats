<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class AdminController extends Controller
{
    // 1. Show all Pending Top-Ups
    public function index()
    {
        // Get only 'pending' deposits
        $pendingTransactions = Transaction::where('status', 'pending')
                                        ->where('type', 'deposit')
                                        ->with('user') // Eager load user name
                                        ->latest()
                                        ->get();

        return view('admin.index', compact('pendingTransactions'));
    }

    // 2. Approve a Top-Up
    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);

        if($transaction->status == 'approved') {
            return back()->with('error', 'Already approved!');
        }

        // A. Credit the User's Wallet
        $user = User::findOrFail($transaction->user_id);
        $user->wallet_balance += $transaction->amount;
        $user->save();

        // B. Mark Transaction as Approved
        $transaction->status = 'approved';
        $transaction->save();

        return back()->with('success', 'Approved! Money added to user.');
    }

    // 3. Reject a Top-Up
    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 'rejected';
        $transaction->save();

        return back()->with('success', 'Transaction rejected.');
    }
}