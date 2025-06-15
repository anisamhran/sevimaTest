@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header Profil --}}
    <div class="flex flex-col sm:flex-row items-center sm:items-start sm:justify-between mb-10">
        <div class="flex items-center gap-6">
            {{-- Foto Profil --}}
            <div class="w-24 h-24 rounded-full bg-gray-300 overflow-hidden">
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                    class="w-full h-full object-cover" alt="Avatar">
            </div>

            {{-- Info User --}}
            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">@{{ $user->username }}</p>
                <p class="mt-1 text-gray-700 text-sm">{{ $user->bio ?? 'Belum ada bio.' }}</p>

                {{-- Tambahan Informasi --}}
                <div class="flex gap-4 mt-2 text-sm text-gray-600">
                    <a href="{{ route('profile.following') }}" class="hover:underline">
                        <strong>{{ $user->following()->count() }}</strong> Mengikuti
                    </a>
                    <span>
                        <strong>{{ $user->followers()->count() }}</strong> Pengikut
                    </span>
                    <span>
                        <strong>{{ $posts->count() }}</strong> Postingan
                    </span>
                </div>

                <p class="text-xs text-gray-400 mt-1">Bergabung {{ $user->created_at->diffForHumans() }}</p>
            </div>

        </div>

        {{-- Tombol Edit --}}
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Edit Profil
            </a>
        </div>
    </div>

    {{-- Postingan --}}
    <h2 class="text-xl font-semibold mb-4">Postingan Saya</h2>

    @if ($posts->count())
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($posts as $post)
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="post" class="w-full h-48 object-cover">
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-500 mt-6 text-center">Kamu belum membuat postingan apa pun.</div>
    @endif
</div>
@endsection
