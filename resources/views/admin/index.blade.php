@extends('layouts.mobile')

@section('title', 'Admin - Banker Dashboard')

@section('content')
<div class="pt-6 px-4 pb-20">
    <h1 class="text-xl font-bold text-gray-800 mb-6">🏦 Banker Dashboard</h1>

    <h2 class="font-bold text-gray-600 mb-4 text-sm">Pending Approvals ({{ $pendingTransactions->count() }})</h2>

    @forelse($pendingTransactions as $txn)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-4">
        <div class="flex justify-between items-start mb-3">
            <div>
                <p class="font-bold text-gray-800">{{ $txn->user->name }}</p>
                <p class="text-xs text-gray-500">{{ $txn->user->email }}</p>
            </div>
            <span class="text-lg font-bold text-teal-600">+ RM {{ $txn->amount }}</span>
        </div>

        @if($txn->proof_image)
        <div class="mb-4 bg-gray-100 rounded-lg p-2">
            <p class="text-[10px] text-gray-400 mb-1">Receipt Proof:</p>
            <a href="{{ asset('storage/' . $txn->proof_image) }}" target="_blank">
                <img src="{{ asset('storage/' . $txn->proof_image) }}" class="h-24 rounded border border-gray-300">
            </a>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-3">
            <form action="{{ route('admin.reject', $txn->id) }}" method="POST">
                @csrf
                <button class="w-full py-2 rounded-lg border border-red-200 text-red-600 text-xs font-bold hover:bg-red-50">
                    Reject
                </button>
            </form>

            <form action="{{ route('admin.approve', $txn->id) }}" method="POST">
                @csrf
                <button class="w-full py-2 rounded-lg bg-teal-600 text-white text-xs font-bold hover:bg-teal-700 shadow-md shadow-teal-200">
                    Approve & Pay
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-10 text-gray-400">
        <i class="fa-solid fa-clipboard-check text-4xl mb-3"></i>
        <p>All caught up! No pending requests.</p>
    </div>
    @endforelse

</div>
@endsection