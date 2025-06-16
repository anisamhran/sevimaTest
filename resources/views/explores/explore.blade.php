@extends('layouts.app')

@section('title', 'Jelajahi')

@section('content')
<div class="w-full">
    <h2 class="text-2xl font-semibold mb-6">Temukan Postingan Baru</h2>

    @if ($posts->count())
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($posts as $post)
                <a href="{{ route('posts.show', $post) }}" class="block bg-white rounded-xl shadow hover:opacity-90 transition overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post" class="w-full h-48 object-cover">
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Belum ada postingan dari pengguna lain untuk dijelajahi.</p>
    @endif
</div>
@endsection
