@extends('layouts.mobile')

@section('title', 'Home - Campus Eats')

@section('content')
    @if(session('success'))
        <div id="success-toast" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-[100] bg-teal-800 text-white px-6 py-3 rounded-full shadow-2xl text-xs font-bold animate-bounce flex items-center gap-2 pointer-events-none">
            <i class="fa-solid fa-check-circle text-lg"></i> 
            <span>{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('success-toast');
                if(toast) { toast.style.opacity = "0"; setTimeout(() => toast.remove(), 500); }
            }, 2000);
        </script>
    @endif

    <div class="bg-teal-600 p-4 rounded-b-3xl shadow-md sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <form action="{{ route('home') }}" method="GET" class="flex-1">
                <div class="bg-white rounded-full flex items-center px-4 py-2 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Jollof..." class="ml-3 w-full outline-none text-sm text-gray-600 placeholder-gray-400">
                </div>
            </form>

            @auth
                <a href="{{ route('cart.index') }}" class="w-10 h-10 flex items-center justify-center bg-white/20 rounded-full text-white hover:bg-white/30 transition shadow-sm relative">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-teal-600"></span>
                    @endif
                </a>
                <a href="{{ url('/profile') }}" class="w-10 h-10 flex items-center justify-center bg-white/20 rounded-full text-white hover:bg-white/30 transition shadow-sm">
                    @if(auth()->user()->avatar ?? false)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <i class="fa-regular fa-user"></i>
                    @endif
                </a>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="w-10 h-10 flex items-center justify-center bg-white text-teal-600 rounded-full shadow-sm font-bold text-xs">
                    Login
                </a>
            @endguest
        </div>
    </div>

    <div class="px-4 mt-6">
        <div class="grid grid-cols-4 gap-y-6 gap-x-2 text-center">
            <div class="flex flex-col items-center"><div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-2 shadow-sm"><i class="fa-solid fa-utensils text-xl"></i></div><span class="text-xs font-semibold text-gray-700">Meals</span></div>
            <div class="flex flex-col items-center"><div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-2 shadow-sm"><i class="fa-solid fa-cookie-bite text-xl"></i></div><span class="text-xs font-semibold text-gray-700">Snacks</span></div>
            <div class="flex flex-col items-center"><div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-2 shadow-sm"><i class="fa-solid fa-bottle-water text-xl"></i></div><span class="text-xs font-semibold text-gray-700">Drinks</span></div>
            <div class="flex flex-col items-center"><div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-2 shadow-sm"><i class="fa-solid fa-basket-shopping text-xl"></i></div><span class="text-xs font-semibold text-gray-700">Mart</span></div>
        </div>
    </div>

    <div class="px-4 mt-8">
        @auth
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800">Campus Wallet</h3>
                    <p class="text-xs text-gray-500">
                        Balance: <span class="font-bold text-teal-600">RM {{ number_format(auth()->user()->wallet_balance, 2) }}</span>
                    </p>
                </div>
                <a href="{{ route('wallet.topup') }}" class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition">Top Up</a>
            </div>
        @endauth
    </div>

    <div class="mt-8 px-4 pb-20">
        <h2 class="font-bold text-lg text-gray-800 mb-4">Popular Dishes</h2>

        <div class="grid grid-cols-2 gap-3">
            @forelse($menuItems as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full relative">
                
                @php
                    $imageUrl = str_starts_with($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path);
                    
                    // Check if it has variants (for "From RM..." logic)
                    $hasVariants = $item->variants->count() > 0;
                    $displayPrice = $hasVariants ? $item->variants->min('price') : $item->price;
                @endphp
                
                <div class="h-32 w-full bg-gray-200 bg-cover bg-center" style="background-image: url('{{ $imageUrl }}');"></div>

                <div class="p-3 flex flex-col flex-1">
                    <h3 class="font-bold text-sm text-gray-800 leading-tight mb-1 line-clamp-1">{{ $item->name }}</h3>
                    
                    <div class="mb-2">
                        @if($hasVariants)
                            <span class="text-[10px] text-gray-400 font-normal">From</span>
                        @endif
                        <span class="text-xs font-bold text-teal-600">RM {{ number_format($displayPrice, 2) }}</span>
                    </div>

                    <p class="text-[10px] text-gray-500 leading-relaxed mb-3 line-clamp-2">{{ $item->description }}</p>
                    
                    <button 
                        onclick="openVariantModal('{{ $item->name }}', '{{ $imageUrl }}', {{ json_encode($item->variants) }})"
                        class="mt-auto w-full block text-center bg-teal-50 text-teal-700 text-[10px] font-bold py-2 rounded border border-teal-100 hover:bg-teal-100 active:bg-teal-200 transition">
                        ADD +
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-10 text-gray-400">
                <p>No meals available right now.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div id="variantModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeVariantModal()"></div>
        
        <div class="absolute bottom-0 w-full bg-white rounded-t-3xl p-6 animate-slide-up">
            
            <div class="flex gap-4 items-center mb-6">
                <div id="modalImage" class="w-16 h-16 rounded-lg bg-gray-200 bg-cover bg-center"></div>
                <div>
                    <h3 id="modalTitle" class="font-bold text-xl text-gray-800">Dish Name</h3>
                    <p class="text-xs text-gray-400">Select your portion size</p>
                </div>
            </div>

            <form action="{{ route('cart.add.variant') }}" method="POST">
                @csrf
                <div id="variantOptions" class="space-y-3 mb-6"></div>

                <button type="submit" class="w-full bg-teal-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-teal-700 transition">
                    Add to Cart
                </button>
            </form>

            <button onclick="closeVariantModal()" class="w-full mt-3 text-gray-400 text-sm py-2">Cancel</button>
        </div>
    </div>

    <script>
        function openVariantModal(name, image, variants) {
            // 1. Populate basic info
            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalImage').style.backgroundImage = `url('${image}')`;
            
            // 2. Build the list of options (Radio Buttons)
            const container = document.getElementById('variantOptions');
            container.innerHTML = ''; // Clear old options

            variants.forEach((variant, index) => {
                // Determine if it's sold out
                const isAvailable = variant.is_available == 1;
                const opacity = isAvailable ? 'opacity-100' : 'opacity-50 pointer-events-none grayscale';
                const checked = index === 0 ? 'checked' : ''; // Select first one by default

                const html = `
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-teal-500 transition ${opacity} bg-white relative overflow-hidden group">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="variant_id" value="${variant.id}" ${checked} class="w-4 h-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                            <div>
                                <span class="font-bold text-gray-800 text-sm block">${variant.name}</span>
                                <span class="text-[10px] text-gray-500">${variant.capacity_info || ''}</span>
                            </div>
                        </div>
                        <span class="font-bold text-teal-600 text-sm">RM ${parseFloat(variant.price).toFixed(2)}</span>
                        
                        ${!isAvailable ? '<span class="absolute inset-0 bg-white/60 flex items-center justify-center text-red-500 font-bold text-xs uppercase tracking-widest border-2 border-red-500 transform -rotate-3">Sold Out</span>' : ''}
                    </label>
                `;
                container.innerHTML += html;
            });

            // 3. Show the modal
            document.getElementById('variantModal').classList.remove('hidden');
        }

        function closeVariantModal() {
            document.getElementById('variantModal').classList.add('hidden');
        }
    </script>

    <style>
        @keyframes slide-up {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        .animate-slide-up {
            animation: slide-up 0.3s ease-out forwards;
        }
    </style>
@endsection