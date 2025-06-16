@extends('layouts.app')

@section('title', '@' . $user->username)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-6 mb-6">
        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
             alt="Avatar" class="w-20 h-20 rounded-full object-cover">
        <div>
            <h1 class="text-xl font-bold">{{ $user->name }}</h1>
            <p class="text-sm text-gray-500">{{ '@' . $user->username }}</p>
            <p class="text-sm text-gray-600">{{ $user->bio ?? 'Tidak ada bio.' }}</p>

            <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                <span><strong>{{ $user->followers()->count() }}</strong> Pengikut</span>
                <span><strong>{{ $user->following()->count() }}</strong> Mengikuti</span>
            </div>

            @auth
                @if (auth()->id() !== $user->id)
                    <form method="POST" action="{{ route('follow.toggle', $user) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="px-4 py-1 rounded bg-blue-500 text-white hover:bg-blue-600">
                            {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <h2 class="text-lg font-semibold mb-4">Postingan</h2>

    @if ($posts->count())
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($posts as $post)
    <a href="{{ route('posts.show', $post) }}" class="block bg-white rounded-xl shadow overflow-hidden hover:opacity-90 transition">
        <img src="{{ asset('storage/' . $post->image) }}" alt="post" class="w-full h-48 object-cover">
    </a>
@endforeach

        </div>
    @else
        <div class="text-gray-500 mt-6 text-center">Kamu belum membuat postingan apa pun.</div>
    @endif
</div>
@endsection
