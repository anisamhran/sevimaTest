@extends('layouts.app')

@section('title', 'Mengikuti')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Akun yang Kamu Ikuti</h2>

    @forelse ($following as $followedUser)
        <div class="flex items-center gap-4 mb-4 bg-white p-4 rounded-xl shadow">
            <img src="{{ $followedUser->profile_picture ? asset('storage/' . $followedUser->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($followedUser->name) }}" 
                 alt="Avatar" class="w-10 h-10 rounded-full object-cover">
            <div>
                <p class="font-semibold">{{ $followedUser->name }} (@{{ $followedUser->username }})</p>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Kamu belum mengikuti siapa pun.</p>
    @endforelse
</div>
@endsection
