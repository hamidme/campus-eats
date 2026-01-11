@extends('layouts.mobile')

@section('title', 'Menu Manager')

@section('content')
<div class="pt-6 px-4 pb-24 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-800">My Menu</h1>
            <p class="text-xs text-gray-500">Manage availability</p>
        </div>
        <a href="{{ route('home') }}" class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow text-gray-600">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>

    @if($items->count() > 0)
        <div class="grid gap-4">
            @foreach($items as $item)
            
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex justify-between items-center transition-opacity duration-300 {{ $item->is_available ? 'opacity-100' : 'opacity-60 bg-gray-50' }}">
                    
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0 relative">
                            @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-utensils text-xl"></i>
                                </div>
                            @endif
                            
                            @if(!$item->is_available)
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <i class="fa-solid fa-ban text-white drop-shadow-md"></i>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 text-sm leading-tight mb-1">{{ $item->name }}</h3>
                            <p class="text-xs text-gray-500 font-medium">RM {{ number_format($item->price, 2) }}</p>
                            
                            @if($item->is_available)
                                <span class="text-[10px] text-green-600 font-bold flex items-center gap-1 mt-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Online
                                </span>
                            @else
                                <span class="text-[10px] text-red-500 font-bold mt-1 block">Sold Out</span>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('vendor.toggle', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors duration-200 focus:outline-none 
                            {{ $item->is_available ? 'bg-green-500' : 'bg-gray-300' }}">
                            
                            <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform duration-200 ease-in-out
                                {{ $item->is_available ? 'translate-x-6' : 'translate-x-1' }}">
                            </span>
                        </button>
                    </form>

                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-64 text-gray-400">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <i class="fa-solid fa-burger text-2xl"></i>
            </div>
            <p class="font-bold text-gray-600">No items yet</p>
            <p class="text-xs">Add items to your database first.</p>
        </div>
    @endif
</div>
@endsection