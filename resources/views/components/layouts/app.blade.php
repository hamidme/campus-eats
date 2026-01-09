<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#16a34a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"> 
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Eats</title>
    <script src="https://cdn.tailwindcss.com"></script> 
</head>
<body class="bg-gray-50 text-gray-800 font-sans pb-24 min-h-screen">
    <div id="splash-screen" class="fixed inset-0 bg-white z-[9999] flex flex-col items-center justify-center transition-opacity duration-500">
    
        <div class="mb-6 animate-pulse">
            <img src="/images/logo.png" alt="Campus Eats Logo" class="w-32 h-auto mx-auto">
        </div>

        <div class="w-12 h-12 border-4 border-orange-200 border-t-orange-600 rounded-full animate-spin mb-4"></div>

        <div class="w-48 h-2 bg-gray-200 rounded-full overflow-hidden relative">
            <div id="loading-bar" class="absolute top-0 left-0 h-full bg-orange-600 w-0 transition-all duration-[2000ms] ease-out"></div>
        </div>

        <p class="mt-4 text-gray-500 text-sm font-medium animate-pulse">Loading Campus Eats...</p>

    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Start the loading bar animation immediately
        setTimeout(() => {
            document.getElementById('loading-bar').style.width = '90%';
        }, 100);

        // 2. When the page is fully loaded (images, scripts, etc.)
        window.addEventListener('load', function() {
            // Finish the bar
            document.getElementById('loading-bar').style.width = '100%';
            
            // Wait a tiny bit for the bar to finish, then fade out
            setTimeout(() => {
                const splash = document.getElementById('splash-screen');
                splash.style.opacity = '0'; // Fade out effect
                
                // Remove it from the HTML entirely so it doesn't block clicks
                setTimeout(() => {
                    splash.remove();
                }, 500); 
            }, 800);
        });
    });
</script>
    
    

    <div class="bg-teal-600 p-4 rounded-b-3xl shadow-md sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="flex-1 bg-white rounded-full flex items-center px-4 py-2 shadow-sm">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                <input type="text" placeholder="Search Jollof, Egusi..." class="ml-3 w-full outline-none text-sm text-gray-600 placeholder-gray-400">
            </div>
            <div class="bg-white/20 p-2 rounded-full text-white">
                <i class="fa-regular fa-user"></i>
            </div>
        </div>
    </div>

    <div class="px-4 mt-6">
        <div class="grid grid-cols-4 gap-y-6 gap-x-2 text-center">
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-2 shadow-sm"><i class="fa-solid fa-utensils text-xl"></i></div>
                <span class="text-xs font-semibold text-gray-700">Meals</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-2 shadow-sm"><i class="fa-solid fa-cookie-bite text-xl"></i></div>
                <span class="text-xs font-semibold text-gray-700">Snacks</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-2 shadow-sm"><i class="fa-solid fa-bottle-water text-xl"></i></div>
                <span class="text-xs font-semibold text-gray-700">Drinks</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-2 shadow-sm"><i class="fa-solid fa-basket-shopping text-xl"></i></div>
                <span class="text-xs font-semibold text-gray-700">Mart</span>
            </div>
        </div>
    </div>

    <div class="px-4 mt-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-gray-800">Campus Wallet</h3>
                <p class="text-xs text-gray-500">Balance: RM 15.50</p>
            </div>
            <button class="bg-teal-600 text-white text-sm px-4 py-2 rounded-lg font-medium">Top Up</button>
        </div>
    </div>

    <div class="mt-8 px-4 pb-24">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-lg text-gray-800">Popular Dishes</h2>
            <i class="fa-solid fa-filter text-teal-600"></i>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @foreach($menuItems as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                
                <div class="aspect-[4/3] bg-gray-200 bg-cover bg-center" 
                     style="background-image: url('{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}');">
                </div>

                <div class="p-3 flex flex-col flex-1">
                    <h3 class="font-bold text-sm text-gray-800 leading-tight mb-1">{{ $item->name }}</h3>
                    <span class="text-xs font-bold text-teal-600 mb-2">RM {{ number_format($item->price, 2) }}</span>
                    
                    <p class="text-[10px] text-gray-500 leading-relaxed mb-3 flex-1">
                        {{ $item->description }}
                    </p>

                    <button class="w-full bg-teal-50 text-teal-700 text-[10px] font-bold py-2 rounded border border-teal-100 hover:bg-teal-100">
                        ADD +
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="fixed bottom-0 w-full bg-white border-t border-gray-200 flex justify-around py-3 px-2 z-50 safe-area-bottom">
        <div class="flex flex-col items-center text-teal-600">
            <i class="fa-solid fa-house text-xl mb-1"></i>
            <span class="text-[10px] font-medium">Home</span>
        </div>
        <div class="flex flex-col items-center text-gray-400 hover:text-teal-600">
            <i class="fa-solid fa-receipt text-xl mb-1"></i>
            <span class="text-[10px] font-medium">Orders</span>
        </div>
        <div class="flex flex-col items-center text-gray-400 hover:text-teal-600">
            <i class="fa-solid fa-user text-xl mb-1"></i>
            <span class="text-[10px] font-medium">Profile</span>
        </div>
    </div>



<div id="install-banner" class="hidden fixed bottom-0 left-0 right-0 bg-white shadow-2xl p-4 border-t border-gray-200 z-50">
    <div class="flex items-center justify-between max-w-md mx-auto">
        <div class="flex items-center space-x-3">
            <div class="bg-orange-500 text-white p-2 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Install Campus Eats</h3>
                <p class="text-xs text-gray-500">Order food faster & easier</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <button id="dismiss-btn" class="text-gray-400 hover:text-gray-600">✕</button>
            <button id="install-btn" class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md">Install</button>
        </div>
    </div>
</div>

<script>
    let deferredPrompt;
    const installBanner = document.getElementById('install-banner');
    const installBtn = document.getElementById('install-btn');
    const dismissBtn = document.getElementById('dismiss-btn');

    // 1. Listen for the 'beforeinstallprompt' event
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Show the banner
        installBanner.classList.remove('hidden');
    });

    // 2. Handle the "Install" button click
    installBtn.addEventListener('click', (e) => {
        // Hide the banner
        installBanner.classList.add('hidden');
        // Show the install prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the A2HS prompt');
            }
            deferredPrompt = null;
        });
    });

    // 3. Handle the "Dismiss" (X) button
    dismissBtn.addEventListener('click', () => {
        installBanner.classList.add('hidden');
    });
</script>
</body>
</html>