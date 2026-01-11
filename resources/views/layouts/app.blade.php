<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Campus Eats')</title>
    
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d9488">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Hide scrollbar for cleaner UI */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body { -webkit-tap-highlight-color: transparent; }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 font-sans min-h-screen selection:bg-teal-100">

    <div id="splash-screen" class="fixed inset-0 bg-white z-[9999] flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="mb-6 animate-pulse">
            <i class="fa-solid fa-bowl-food text-6xl text-teal-600"></i>
        </div>
        <div class="w-12 h-12 border-4 border-teal-200 border-t-teal-600 rounded-full animate-spin mb-4"></div>
        <p class="mt-4 text-gray-500 text-sm font-medium animate-pulse">Loading Campus Eats...</p>
    </div>

    <div class="w-full max-w-md mx-auto bg-gray-50 min-h-screen shadow-2xl relative pb-24">
        
        <main>
            @yield('content')
        </main>

        <div class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto bg-white border-t border-gray-200 flex justify-around py-4 pb-6 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
            
            <a href="{{ url('/') }}" class="flex flex-col items-center w-16 {{ Request::is('/') ? 'text-teal-600' : 'text-gray-400 hover:text-teal-600 transition' }}">
                <i class="fa-solid fa-house text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            <a href="{{ url('/orders') }}" class="flex flex-col items-center w-16 {{ Request::is('orders*') ? 'text-teal-600' : 'text-gray-400 hover:text-teal-600 transition' }}">
                <i class="fa-solid fa-receipt text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Orders</span>
            </a>

            <a href="{{ url('/profile') }}" class="flex flex-col items-center w-16 {{ Request::is('profile*') ? 'text-teal-600' : 'text-gray-400 hover:text-teal-600 transition' }}">
                <i class="fa-solid fa-user text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Profile</span>
            </a>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const splash = document.getElementById('splash-screen');
            if (sessionStorage.getItem('splashSeen') === 'true') {
                splash.style.display = 'none';
            } else {
                setTimeout(() => {
                    splash.style.opacity = '0';
                    setTimeout(() => { 
                        splash.remove(); 
                        sessionStorage.setItem('splashSeen', 'true'); 
                    }, 500);
                }, 1000);
            }
        });
    </script>
</body>
</html>