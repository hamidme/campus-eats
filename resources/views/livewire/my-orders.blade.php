<div class="max-w-md mx-auto p-4 space-y-6 pb-20">
    <div class="flex items-center gap-4 border-b pb-4">
        <a href="/" class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-bold">My Orders</h2>
    </div>

    @if($orders->isEmpty())
        <div class="text-center py-10 text-gray-400">
            No orders found. <br>
            <a href="/" class="text-green-600 font-bold underline">Order something tasty!</a>
        </div>
    @else

        @foreach($orders as $order)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <span class="text-xs text-gray-500">Order #{{ $order->id }}</span>
                    <h3 class="font-bold text-gray-800">{{ $order->vendor->kitchen_name ?? 'Unknown Vendor' }}</h3>
                </div>
                
                @php
                    $statusColor = match($order->status) {
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'preparing' => 'bg-blue-100 text-blue-800',
                        'ready' => 'bg-green-100 text-green-800',
                        'completed' => 'bg-gray-100 text-gray-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColor }}">
                    {{ $order->status }}
                </span>
            </div>

            <div class="p-4 space-y-2">
                {{-- The '?? []' tells Laravel: If items is null, use an empty list [] --}}
                @foreach(is_string($order->items) ? json_decode($order->items, true) : $order->items as $item) 
                    <div class="flex justify-between text-sm">
                        {{-- Use brackets [] instead of arrows -> --}}
                        {{-- Also changed 'menu_item_name' to 'name' to match your Cart data --}}
                        <span class="text-gray-600">
                            {{ $item['quantity'] }}x {{ $item['name'] }}
                        </span>
                        
                        <span class="font-semibold">
                            RM {{ number_format($item['price'], 2) }}
                        </span>
                    </div>
                @endforeach
                
                <div class="border-t border-dashed border-gray-200 mt-3 pt-3 flex justify-between font-bold">
                    <span>Total</span>
                    <span>RM {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="px-4 py-2 bg-gray-50 text-xs text-gray-400 text-right">
                {{ $order->created_at->format('d M Y, h:i A') }}
            </div>
        </div>
        @endforeach

    @endif
</div>