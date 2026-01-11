@extends('layouts.mobile')

@section('title', 'My Orders')

@section('content')
    <div class="pt-6 px-4 pb-20">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Order History</h1>

        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col gap-3">
                    
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-teal-50 rounded-full flex items-center justify-center text-teal-600">
                                <i class="fa-solid fa-shop"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm">
                                    {{ $order->vendor->name ?? 'Campus Vendor' }}
                                </h3>
                                <p class="text-xs text-gray-400">
                                    {{ $order->created_at->format('d M, h:i A') }}
                                </p>
                            </div>
                        </div>
                        
                        @php
                            $statusColor = match($order->status) {
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-yellow-100 text-yellow-700', // Pending/Processing
                            };
                        @endphp
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $statusColor }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <hr class="border-gray-50">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-[10px] text-gray-400">Total Amount</p>
                            <p class="font-bold text-teal-600">RM {{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs px-3 py-1.5 rounded-lg font-medium transition">
                            Details
                        </button>
                    </div>
                </div>

            @empty
                <div class="flex flex-col items-center justify-center pt-20 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-receipt text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-gray-800 font-bold">No orders yet</h3>
                    <p class="text-gray-400 text-sm mb-6">Looks like you haven't ordered anything yet.</p>
                    <a href="{{ url('/') }}" class="bg-teal-600 text-white px-6 py-2 rounded-xl text-sm font-bold shadow-lg shadow-teal-200">
                        Start Ordering
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection