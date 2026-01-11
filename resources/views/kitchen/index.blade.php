@extends('layouts.mobile')

@section('title', 'Kitchen Display System')

@section('content')
<script>
    setTimeout(function(){
       window.location.reload(1);
    }, 30000);
</script>

<div class="pt-6 px-4 pb-24 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-black text-gray-800">👨‍🍳 Kitchen Board</h1>
        <div class="text-xs font-bold text-gray-400 bg-white px-3 py-1 rounded-full shadow-sm">
            Auto-refresh: ON 🟢
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="columns-1 md:columns-2 lg:columns-3 gap-4">
            @foreach($orders as $order)
                @php
                    $borderColor = match($order->status) {
                        'pending' => 'border-yellow-400',
                        'cooking' => 'border-blue-500',
                        'ready'   => 'border-green-500',
                        default   => 'border-gray-200'
                    };
                    
                    $bgColor = match($order->status) {
                        'pending' => 'bg-yellow-50',
                        'cooking' => 'bg-blue-50',
                        'ready'   => 'bg-green-50',
                        default   => 'bg-white'
                    };
                @endphp

                <div class="break-inside-avoid mb-4 bg-white rounded-xl shadow-md border-l-8 {{ $borderColor }} overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-start {{ $bgColor }}">
                        <div>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Order #{{ $order->id }}</span>
                            <h2 class="font-bold text-lg text-gray-800">{{ $order->user->name }}</h2>
                            <p class="text-[10px] text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-white shadow-sm
                            {{ $order->status == 'pending' ? 'text-yellow-600' : '' }}
                            {{ $order->status == 'cooking' ? 'text-blue-600' : '' }}
                            {{ $order->status == 'ready' ? 'text-green-600' : '' }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="p-4 bg-white">
                        <ul class="space-y-3">
                            @foreach($order->orderItems as $item)
                                <li class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center font-bold text-gray-700 text-sm">
                                            {{ $item->quantity }}x
                                        </span>
                                        <span class="font-bold text-gray-700 text-lg">{{ $item->menu_name }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="p-3 bg-gray-50 flex gap-2">
                        @if($order->status == 'pending')
                            <form action="{{ route('kitchen.update', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="cooking">
                                <button class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition flex justify-center items-center gap-2">
                                    <i class="fa-solid fa-fire-burner"></i> Start Cooking
                                </button>
                            </form>
                        @elseif($order->status == 'cooking')
                            <form action="{{ route('kitchen.update', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="ready">
                                <button class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition flex justify-center items-center gap-2">
                                    <i class="fa-solid fa-bell"></i> Mark Ready
                                </button>
                            </form>
                        @elseif($order->status == 'ready')
                            <form action="{{ route('kitchen.update', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button class="w-full bg-gray-800 text-white font-bold py-3 rounded-lg hover:bg-gray-900 transition flex justify-center items-center gap-2">
                                    <i class="fa-solid fa-check"></i> Pickup Complete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-64 text-gray-400">
            <i class="fa-solid fa-mug-hot text-5xl mb-4 animate-bounce"></i>
            <p class="font-bold">No active orders</p>
            <p class="text-xs">Waiting for students...</p>
        </div>
    @endif
</div>
@endsection