<div class="p-6 max-w-md mx-auto space-y-6 pb-20">
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('message') }}
        </div>
    @endif

    <div class="text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
        
        @if(!$isEditing)
            <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500">{{ $user->email }}</p>
        @else
            <h2 class="text-xl font-bold text-gray-800 mb-2">Edit Profile</h2>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        @if($isEditing)
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Full Name</label>
                    <input type="text" wire:model="name" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-green-500">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Phone (WhatsApp)</label>
                    <input type="text" wire:model="phone" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-green-500">
                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Email Address</label>
                    <input type="email" wire:model="email" class="w-full border-b border-gray-300 py-2 focus:outline-none focus:border-green-500">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-2 pt-2">
                    <button wire:click="save" class="flex-1 bg-green-600 text-white py-2 rounded-lg font-bold">Save</button>
                    <button wire:click="toggleEdit" class="flex-1 bg-gray-100 text-gray-600 py-2 rounded-lg font-bold">Cancel</button>
                </div>
            </div>

        @else
            <div class="divide-y divide-gray-100">
                <div class="p-4 flex justify-between items-center">
                    <span class="text-gray-600">Phone</span>
                    <span class="font-medium">{{ $user->phone ?? 'Not set' }}</span>
                </div>
                <div class="p-4 flex justify-between items-center">
                    <span class="text-gray-600">Email</span>
                    <span class="font-medium text-sm">{{ $user->email }}</span>
                </div>
                <div class="p-4 flex justify-between items-center">
                    <span class="text-gray-600">Role</span>
                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full uppercase font-bold">
                        {{ $user->role }}
                    </span>
                </div>
            </div>
        @endif
    </div>

    @if(!$isEditing)
    <div class="space-y-3">
        <button wire:click="toggleEdit" class="block w-full text-center py-3 bg-white border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-gray-50">
            Edit Details
        </button>

        <a href="{{ route('my-orders') }}" class="block w-full text-center py-3 border border-gray-200 rounded-xl font-bold text-gray-700 hover:bg-gray-50">
            My Order History
        </a>

        <button wire:click="logout" class="w-full bg-red-50 text-red-600 py-3 rounded-xl font-bold hover:bg-red-100">
            Log Out
        </button>
    </div>
    @endif

</div>