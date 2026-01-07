<div class="space-y-4">
    <div class="flex gap-2">
        <input wire:model.live="search" type="text" placeholder="Search Jollof, Egusi..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-500">
    </div>

    <!-- <div class="flex justify-between items-center mb-6">
        
        <a href="{{ route('my-orders') }}" class="text-sm font-bold text-green-600 bg-green-50 px-3 py-1 rounded-lg">
            My Orders
        </a>
    </div> -->

    @foreach($menuItems as $item)
    <div class="bg-white rounded-lg border border-gray-100 shadow-sm flex overflow-hidden h-28">
        <div class="w-1/3 bg-gray-200">
            <img src="{{ str_starts_with($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path) }}" 
            class="h-full w-full object-cover">
        </div>
        <div class="w-2/3 p-3 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-gray-800 text-sm">{{ $item->name }}</h3>
                <p class="text-xs text-gray-500">{{ $item->description }}</p>
            </div>
            <div class="flex justify-between items-end">
                <span class="font-bold text-lg text-gray-900">RM {{ number_format($item->price, 2) }}</span>
                
                <button 
                    wire:click="addToCart({{ $item->id }})" 
                    class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700 active:bg-green-800 transition">
                    ADD +
                </button>
            </div>
        </div>
    </div>
    @endforeach

    @if($menuItems->isEmpty())
        <div class="text-center text-gray-500 py-10">
            No food found matching "{{ $search }}"
        </div>
    @endif

    @if($cartCount > 0)
    <div class="fixed bottom-16 left-0 right-0 px-4 z-40">
        <div class="bg-green-600 text-white p-4 rounded-xl shadow-lg flex justify-between items-center max-w-md mx-auto">
            <div class="flex flex-col">
                <span class="font-bold text-lg">{{ $cartCount }} Items</span>
                <span class="text-xs text-green-100">View your cart</span>
            </div>
            <a href="/cart" class="bg-white text-green-600 px-4 py-2 rounded-lg font-bold text-sm">
                Checkout >
            </a>
        </div>
    </div>
    @endif
</div>