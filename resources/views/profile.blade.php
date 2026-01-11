@extends('layouts.mobile')

@section('title', 'My Profile')

@section('content')
<div class="pt-6 px-4 pb-24">
    
    <div class="flex items-center gap-4 mb-8">
        <div class="w-16 h-16 bg-gray-200 rounded-full overflow-hidden shadow-sm border-2 border-white">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-teal-100 text-teal-600 font-bold text-xl">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-800">{{ $user->name }}</h1>
            <p class="text-xs text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    <div class="bg-gradient-to-r from-teal-600 to-teal-500 rounded-2xl p-5 text-white shadow-lg mb-8 flex justify-between items-center">
        <div>
            <p class="text-xs opacity-80 mb-1">Wallet Balance</p>
            <h2 class="text-2xl font-bold">RM {{ number_format($user->wallet_balance, 2) }}</h2>
        </div>
        <a href="{{ route('wallet.topup') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-xs font-bold transition backdrop-blur-sm">
            Top Up
        </a>
    </div>

    <h3 class="font-bold text-gray-800 mb-4 px-1">Recent Orders</h3>

    @if($orders->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($orders as $order)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-[10px] text-gray-400">Order #{{ $order->id }}</span>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M, h:i A') }}</p>
                        </div>
                        
                        @php
                            $statusColor = match($order->status) {
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'cooking' => 'bg-blue-100 text-blue-700',
                                'ready'   => 'bg-green-100 text-green-700',
                                'completed' => 'bg-gray-100 text-gray-600',
                                default   => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $statusColor }}">
                            {{ $order->status }}
                        </span>
                    </div>
                    
                    <div class="border-t border-gray-50 pt-3 mt-3">
                        @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center text-sm mb-1">
                                <span class="text-gray-700">
                                    <span class="font-bold text-teal-600 mr-1">{{ $item->quantity }}x</span> 
                                    {{ $item->menu_name }}
                                </span>
                                <span class="text-gray-500 text-xs">RM {{ number_format($item->price, 2) }}</span>
                            </div>
                        @endforeach
                        
                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-dashed border-gray-200">
                            <span class="font-bold text-xs text-gray-600">Total</span>
                            <span class="font-bold text-gray-800">RM {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-10 bg-gray-50 rounded-xl border-dashed border-2 border-gray-200 mb-8">
            <i class="fa-solid fa-pizza-slice text-gray-300 text-2xl mb-2"></i>
            <p class="text-xs text-gray-400">No orders yet.</p>
            <a href="{{ route('home') }}" class="text-teal-600 font-bold text-xs mt-2 block">Order something?</a>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <button class="w-full flex items-center justify-between p-4 border-b border-gray-50 hover:bg-gray-50 text-left">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fa-solid fa-user-pen text-xs"></i></div>
                <span class="text-sm font-medium text-gray-700">Edit Profile</span>
            </div>
            <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        </button>

        <button class="w-full flex items-center justify-between p-4 border-b border-gray-50 hover:bg-gray-50 text-left">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center"><i class="fa-solid fa-lock text-xs"></i></div>
                <span class="text-sm font-medium text-gray-700">Change Password</span>
            </div>
            <i class="fa-solid fa-chevron-right text-xs text-gray-300"></i>
        </button>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-between p-4 hover:bg-red-50 text-left transition group">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-100"><i class="fa-solid fa-arrow-right-from-bracket text-xs"></i></div>
                    <span class="text-sm font-medium text-red-500">Log Out</span>
                </div>
            </button>
        </form>
    </div>

</div>
@endsection