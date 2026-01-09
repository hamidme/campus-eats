<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusEats - Test Design</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .hide-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans pb-24 min-h-screen">

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
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-2 shadow-sm">
                    <i class="fa-solid fa-utensils text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700">Meals</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-2 shadow-sm">
                    <i class="fa-solid fa-cookie-bite text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700">Snacks</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-2 shadow-sm">
                    <i class="fa-solid fa-bottle-water text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700">Drinks</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-2 shadow-sm">
                    <i class="fa-solid fa-basket-shopping text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700">Mart</span>
            </div>
        </div>
    </div>

    <div class="px-4 mt-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-gray-800">Campus Wallet</h3>
                <p class="text-xs text-gray-500">Balance: RM 0.00</p>
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
        @foreach($products as $product)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            
            <div class="aspect-[4/3] bg-gray-200 bg-cover bg-center" 
                 style="background-image: url('{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}');">
            </div>

            <div class="p-3 flex flex-col flex-1">
                <h3 class="font-bold text-sm text-gray-800 leading-tight mb-1">{{ $product->name }}</h3>
                <span class="text-xs font-bold text-teal-600 mb-2">RM {{ number_format($product->price, 2) }}</span>
                
                <p class="text-[10px] text-gray-500 leading-relaxed mb-3 flex-1">
                    {{ $product->description }}
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

</body>
</html>