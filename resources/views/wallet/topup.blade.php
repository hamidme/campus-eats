@extends('layouts.mobile')

@section('title', 'Top Up Wallet')

@section('content')
<div class="pt-6 px-4 pb-20">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('home') }}" class="w-10 h-10 bg-white rounded-full shadow-sm flex items-center justify-center text-gray-600">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Top Up Wallet</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 text-center">
        <h2 class="font-bold text-gray-800 mb-2">Step 1: Scan & Pay</h2>
        <p class="text-xs text-gray-500 mb-4">Scan the QR code below using your TnG eWallet or Bank App.</p>
        
        <div class="w-48 h-48 bg-gray-200 mx-auto rounded-lg flex items-center justify-center mb-4 overflow-hidden border-2 border-teal-500">
            <img src="https://via.placeholder.com/200?text=Your+TnG+QR" class="w-full h-full object-cover">
        </div>
        
        <p class="text-[10px] text-gray-400">Account Name: <strong>Your Name / Company</strong></p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-gray-800 mb-4">Step 2: Upload Receipt</h2>

        <form action="{{ route('wallet.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 mb-1">Amount Transferred (RM)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-bold">RM</span>
                    <input type="number" name="amount" step="0.01" placeholder="0.00" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-12 pr-4 font-bold text-gray-800 focus:outline-none focus:border-teal-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-500 mb-1">Upload Receipt Screenshot</label>
                <input type="file" name="receipt" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"/>
                <p class="text-[10px] text-gray-400 mt-1">Supported: JPG, PNG, PDF</p>
            </div>

            <button type="submit" class="w-full bg-teal-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-teal-700 transition flex justify-center items-center gap-2">
                <i class="fa-solid fa-paper-plane"></i>
                Submit for Verification
            </button>
        </form>
    </div>
    <div class="mt-8">
        <h3 class="font-bold text-gray-800 mb-4 px-2">Recent Activity</h3>

        @if($transactions->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @foreach($transactions as $txn)
                    <div class="p-4 border-b border-gray-50 flex justify-between items-center last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center 
                                {{ $txn->type == 'deposit' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                <i class="fa-solid {{ $txn->type == 'deposit' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                            </div>
                            
                            <div>
                                <p class="text-sm font-bold text-gray-800">
                                    {{ ucfirst($txn->type) }}
                                    
                                    @if($txn->status == 'pending')
                                        <span class="ml-1 text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">Pending</span>
                                    @elseif($txn->status == 'rejected')
                                        <span class="ml-1 text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Rejected</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400">{{ $txn->created_at->format('d M, h:i A') }}</p>
                            </div>
                        </div>

                        <span class="font-bold {{ $txn->type == 'deposit' ? 'text-green-600' : 'text-gray-800' }}">
                            {{ $txn->type == 'deposit' ? '+' : '-' }} RM {{ number_format($txn->amount, 2) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400">
                <p class="text-xs">No transactions yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection