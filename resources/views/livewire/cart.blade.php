<div class="space-y-6 pb-24">
    <div class="flex items-center gap-4 border-b pb-4">
        <a href="/" class="p-2 bg-gray-100 rounded-full hover:bg-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-xl font-bold">Your Order</h2>
    </div>

    @if(empty($groupedItems))
        <div class="text-center py-10 text-gray-400">
            Your cart is empty. <br>
            <a href="/" class="text-green-600 font-bold underline">Go eat something!</a>
        </div>
    @else

        @foreach($groupedItems as $vendorId => $group)
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden mb-6">
            
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-800">{{ $group['name'] ?? 'Unknown Vendor' }}</h3>
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                    {{ count($group['items']) }} Items
                </span>
            </div>

            <div class="p-4 space-y-4">
                @foreach($group['items'] as $itemId => $item)
                <div class="flex gap-4">
                    <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                         <img src="{{ str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1">
                        <h4 class="font-bold text-sm text-gray-800">{{ $item['name'] }}</h4>
                        <p class="text-xs text-green-600 font-bold mb-2">RM {{ number_format($item['price'], 2) }}</p>
                        
                        <div class="flex items-center gap-3">
                            <button wire:click="removeFromCart({{ $itemId }})" class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 font-bold flex items-center justify-center">-</button>
                            <span class="text-xs font-bold">{{ $item['quantity'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-100">
                <button 
                    wire:click="checkout({{ $vendorId }})"
                    class="w-full bg-green-600 text-white py-2 rounded-lg font-bold text-sm shadow hover:bg-green-700 flex justify-center items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Checkout via WhatsApp
                </button>
            </div>
        </div>
        @endforeach

        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-gray-200 z-50">
             <div class="max-w-md mx-auto flex justify-between items-center">
                 <span class="text-gray-500 font-medium">Total Commitment</span>
                 <span class="text-xl font-bold text-gray-900">RM {{ number_format($total, 2) }}</span>
             </div>
        </div>

    @endif
</div>