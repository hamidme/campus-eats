<div class="p-6 max-w-md mx-auto mt-10 bg-white rounded-xl shadow-md border border-gray-100">
    <h2 class="text-2xl font-bold mb-6 text-center">Create Account</h2>

    <form wire:submit.prevent="register" class="space-y-4">
        
        <div>
            <label class="block text-sm font-bold text-gray-700">Name</label>
            <input type="text" wire:model="name" class="w-full p-2 border rounded-lg bg-gray-50">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700">Phone (for WhatsApp)</label>
            <input type="text" wire:model="phone" class="w-full p-2 border rounded-lg bg-gray-50">
            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700">Email</label>
            <input type="email" wire:model="email" class="w-full p-2 border rounded-lg bg-gray-50">
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700">Password</label>
            <input type="password" wire:model="password" class="w-full p-2 border rounded-lg bg-gray-50">
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700">
            Sign Up
        </button>
    </form>
    
    <div class="mt-4 text-center text-sm">
        Already have an account? <a href="/login" class="text-green-600 font-bold">Login here</a>
    </div>
</div>