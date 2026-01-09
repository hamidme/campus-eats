<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d9488">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"> 
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Eats</title>
    
    <script src="https://cdn.tailwindcss.com"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans min-h-screen pb-24 selection:bg-teal-100">

    <div id="splash-screen" class="fixed inset-0 bg-white z-[9999] flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="mb-6 animate-pulse">
            <img src="{{ asset('images/logo.png') }}" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'" 
                 alt="Logo" class="w-32 h-auto mx-auto">
            <i class="fa-solid fa-bowl-food text-6xl text-teal-600 hidden"></i>
        </div>
        <div class="w-12 h-12 border-4 border-teal-200 border-t-teal-600 rounded-full animate-spin mb-4"></div>
        <p class="mt-4 text-gray-500 text-sm font-medium animate-pulse">Loading Campus Eats...</p>
    </div>

    <div class="bg-teal-600 p-4 rounded-b-3xl shadow-md sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <div class="flex-1 bg-white rounded-full flex items-center px-4 py-2 shadow-sm">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                <input type="text" placeholder="Search Jollof, Egusi..." class="ml-3 w-full outline-none text-sm text-gray-600 placeholder-gray-400">
            </div>
            <a href="{{ url('/profile') }}" class="bg-white/20 p-2 rounded-full text-white hover:bg-white/30 transition">
                <i class="fa-regular fa-user"></i>
            </a>
        </div>
    </div>

    <div class="px-4 mt-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-gray-800">Campus Wallet</h3>
                <p class="text-xs text-gray-500">Balance: RM 15.50</p>
            </div>
            <button class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition">Top Up</button>
        </div>
    </div>

    <div class="mt-8 px-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-lg text-gray-800">Popular Dishes</h2>
            <i class="fa-solid fa-filter text-teal-600"></i>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @forelse($menuItems as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
                
                @php
                    $bgImage = $item->image && str_starts_with($item->image, 'http') 
                        ? $item->image 
                        : asset('storage/' . $item->image);
                @endphp
                
                <div class="h-32 w-full bg-gray-200 bg-cover bg-center relative" 
                     style="background-image: url('{{ $bgImage }}');">
                     </div>

                <div class="p-3 flex flex-col flex-1">
                    <h3 class="font-bold text-sm text-gray-800 leading-tight mb-1 line-clamp-1">{{ $item->name }}</h3>
                    <span class="text-xs font-bold text-teal-600 mb-2">RM {{ number_format($item->price, 2) }}</span>
                    
                    <button class="mt-auto w-full bg-teal-50 text-teal-700 text-[10px] font-bold py-2 rounded border border-teal-100 hover:bg-teal-100 active:bg-teal-200 transition">
                        ADD +
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-2 text-center py-10 text-gray-400">
                <i class="fa-solid fa-plate-wheat text-4xl mb-3"></i>
                <p>No meals available right now.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around py-4 pb-6 z-50 safe-area-bottom shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        
        <a href="{{ url('/') }}" class="flex flex-col items-center text-teal-600 w-16">
            <i class="fa-solid fa-house text-2xl mb-1"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>

        <a href="{{ url('/orders') }}" class="flex flex-col items-center text-gray-400 hover:text-teal-600 w-16 transition-colors">
            <i class="fa-solid fa-receipt text-2xl mb-1"></i>
            <span class="text-[10px] font-medium">Orders</span>
        </a>

        <a href="{{ url('/profile') }}" class="flex flex-col items-center text-gray-400 hover:text-teal-600 w-16 transition-colors">
            <i class="fa-solid fa-user text-2xl mb-1"></i>
            <span class="text-[10px] font-medium">Profile</span>
        </a>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const splash = document.getElementById('splash-screen');
            
            // Check if user has already seen splash in this session
            if (sessionStorage.getItem('splashSeen') === 'true') {
                splash.style.display = 'none'; // Hide immediately
            } else {
                // Show splash logic
                setTimeout(() => {
                    splash.style.opacity = '0';
                    setTimeout(() => { 
                        splash.remove(); 
                        sessionStorage.setItem('splashSeen', 'true'); // Mark as seen
                    }, 500);
                }, 1500); // 1.5 seconds delay
            }
        });
    </script>
</body>
</html>