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
<body class="bg-gray-100">
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
    
    <div class="mx-auto min-h-screen w-full max-w-md bg-white shadow-2xl relative pb-20">
        
        <header class="sticky top-0 z-50 bg-green-600 text-white px-4 py-3 shadow-md flex justify-between items-center">
            <h1 class="text-lg font-bold">Campus Eats</h1>
            <div class="text-xs bg-white text-green-600 px-2 py-1 rounded-full font-bold">
                Feel Good Food
            </div>
        </header>

        <main class="p-4 bg-gray-50 min-h-screen">
            {{ $slot }}
        </main>

        <nav class="fixed bottom-0 z-50 w-full max-w-md bg-white border-t border-gray-200 flex justify-around py-3">
            <a href="/" class="text-green-600 flex flex-col items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-xs font-bold mt-1">Home</span>
            </a>
            <a href="{{ route('my-orders') }}" class="flex flex-col items-center gap-1 {{ Request::routeIs('my-orders') ? 'text-green-600' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-xs font-bold">Orders</span>
            </a>

        @auth
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 {{ Request::routeIs('profile') ? 'text-green-600' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-xs font-bold">Profile</span>
            </a>
         @else
            <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 {{ Request::routeIs('login') ? 'text-green-600' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                <span class="text-xs font-bold">Login</span>
            </a>
        @endauth
        </nav>
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