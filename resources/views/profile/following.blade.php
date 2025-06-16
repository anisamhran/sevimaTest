@extends('layouts.app')

@section('title', 'Mengikuti')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Akun yang Kamu Ikuti</h2>

    @forelse ($following as $followedUser)
    <a href="{{ route('user.profile', $followedUser->username) }}" class="flex items-center gap-4 mb-4 bg-white p-4 rounded-xl shadow hover:bg-gray-50 transition">
        <img src="{{ $followedUser->profile_picture ? asset('storage/' . $followedUser->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($followedUser->name) }}" 
             alt="Avatar" class="w-10 h-10 rounded-full object-cover">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">{{ $followedUser->name }}</h3>
            <p class="text-sm text-gray-500">{{ '@' . $followedUser->username }}</p>
        </div>
    </a>
@empty
    <p class="text-gray-500">Kamu belum mengikuti siapa pun.</p>
@endforelse

</div>
@endsection
