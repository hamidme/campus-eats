@extends('layouts.mobile')

@section('title', 'My Cart')

@section('content')
<div class="pt-6 px-4 pb-24">
    <h1 class="text-xl font-bold text-gray-800 mb-6">Your Tray</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm font-bold flex items-center">
            <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm font-bold flex items-center">
            <i class="fa-solid fa-check mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(count($cartItems) > 0)
        
        <div class="space-y-4 mb-8">
            @php $total = 0; @endphp
            @foreach($cartItems as $id => $details)
                @php $total += $details['price'] * $details['quantity']; @endphp
                
                <div class="flex items-center gap-4 bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        @php
                            $imageUrl = str_starts_with($details['image'], 'http') 
                                ? $details['image'] 
                                : asset('storage/' . $details['image']);
                        @endphp
                        <img src="{{ $imageUrl }}" class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-sm line-clamp-1">{{ $details['name'] }}</h3>
                        <p class="text-xs text-gray-500 mb-1">RM {{ number_format($details['price'], 2) }}</p>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded">
                                x {{ $details['quantity'] }}
                            </span>
                        </div>
                    </div>

                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="font-bold text-gray-800 text-sm">
                            RM {{ number_format($details['price'] * $details['quantity'], 2) }}
                        </span>
                        
                        <a href="{{ route('cart.remove', $id) }}" class="flex items-center gap-1 text-red-500 bg-red-50 px-2 py-1 rounded text-[10px] font-bold hover:bg-red-100 transition">
                            <i class="fa-solid fa-trash"></i> 
                            <span>Remove</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white p-5 rounded-t-3xl shadow-[0_-5px_20px_-5px_rgba(0,0,0,0.1)] fixed bottom-[70px] left-0 right-0 w-full max-w-md mx-auto z-40 border-t border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 text-sm">Total Amount</span>
                <span class="text-2xl font-bold text-gray-800">RM {{ number_format($total, 2) }}</span>
            </div>

            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-teal-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-teal-200 flex justify-between px-6 hover:bg-teal-700 transition">
                    <span>Pay with Wallet</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
            
            <p class="text-center text-[10px] text-gray-400 mt-2">
                Your Wallet Balance: RM {{ number_format(auth()->user()->wallet_balance, 2) }}
            </p>
        </div>

    @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                <i class="fa-solid fa-basket-shopping text-3xl"></i>
            </div>
            <h3 class="font-bold text-gray-800">Your tray is empty</h3>
            <p class="text-sm text-gray-400 mt-2 mb-6">Looks like you haven't picked a meal yet.</p>
            <a href="{{ url('/') }}" class="bg-teal-50 text-teal-600 px-6 py-2 rounded-lg font-bold text-sm">
                Browse Menu
            </a>
        </div>
    @endif
</div>
@endsection