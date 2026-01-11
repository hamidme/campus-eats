@extends('layouts.mobile')

@section('title', 'Sign In')

@section('content')
<div class="min-h-screen flex flex-col justify-center px-8 bg-white">
    
    <div class="text-center mb-10">
        <div class="w-20 h-20 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4 text-teal-600">
            <i class="fa-solid fa-bowl-food text-4xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Welcome Back</h1>
        <p class="text-sm text-gray-400 mt-2">Sign in to order your favorite campus meals</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 text-red-600 text-xs font-bold p-3 rounded-lg border border-red-100">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
            <div class="relative">
                <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-gray-400"></i>
                <input type="email" name="email" required 
                       class="w-full bg-gray-50 border border-gray-100 text-gray-800 text-sm rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block pl-10 p-3 outline-none transition" 
                       placeholder="student@fountain.edu.ng">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock absolute left-4 top-3.5 text-gray-400"></i>
                <input type="password" name="password" required 
                       class="w-full bg-gray-50 border border-gray-100 text-gray-800 text-sm rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 block pl-10 p-3 outline-none transition" 
                       placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-teal-200 transition transform active:scale-95">
            Sign In
        </button>
    </form>

    <div class="mt-8 text-center">
        <p class="text-xs text-gray-400">Don't have an account?</p>
        <a href="{{ route('register') }}" class="text-teal-600 font-bold text-sm hover:underline">Create Account</a>
    </div>
</div>
@endsection