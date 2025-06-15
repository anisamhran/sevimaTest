@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Hasil untuk: "{{ $query }}"</h2>

    @if($users->count())
        <ul class="space-y-4">
            @foreach($users as $user)
                <li class="bg-white shadow rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                             class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-semibold">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">@{{ $user->username }}</p>
                        </div>
                    </div>
                    <a href="{{ route('user.profile', $user->username) }}" class="text-blue-500 hover:underline">Lihat</a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">Tidak ditemukan pengguna dengan kata kunci tersebut.</p>
    @endif
</div>
@endsection
