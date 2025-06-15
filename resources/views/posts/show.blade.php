@extends('layouts.app')

@section('title', 'Postingan oleh @' . $post->user->username)

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow mb-6 overflow-hidden">
    
    {{-- Header --}}
    <div class="flex items-center justify-between px-4 py-3">
        <div>
            <span class="font-semibold text-gray-800">{{ '@' . $post->user->username }}</span>
            <span class="text-sm text-gray-400 ml-2">{{ $post->created_at->diffForHumans() }}</span>
        </div>

        @if (auth()->user()->can('update', $post) || auth()->user()->can('delete', $post))
            <div class="relative">
                <button onclick="toggleDropdown({{ $post->id }})" class="text-gray-500 hover:text-gray-700 text-xl">⋯</button>
                <div id="dropdown-{{ $post->id }}" class="hidden absolute right-0 mt-2 w-24 bg-white border rounded shadow text-sm z-10">
                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                    @endcan
                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-500">Hapus</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endif
    </div>

    {{-- Gambar --}}
    <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full max-h-[500px] object-cover">

    {{-- Caption --}}
    <div class="px-4 py-3">
        <p class="text-gray-700"><span class="font-semibold">{{ '@' . $post->user->username }}</span> {{ $post->caption }}</p>
    </div>

    {{-- Like Button --}}
    <div class="px-4 pb-3">
        <button 
            class="like-btn text-sm"
            data-post-id="{{ $post->id }}"
            data-liked="{{ $post->isLikedBy(auth()->user()) ? 'yes' : 'no' }}"
        >
            {{ $post->isLikedBy(auth()->user()) ? '❤️' : '🤍' }}
            <span class="like-count">{{ $post->likes()->count() }}</span> suka
        </button>
    </div>

    {{-- Komentar --}}
<div class="px-4 pb-4">
    @if ($post->comments->count())
        <div class="space-y-2">
            @foreach ($post->comments->take(3) as $comment)
                <div class="text-sm flex justify-between items-start">
                    <div>
                        <span class="font-semibold">{{ '@' . $comment->user->username }}:</span>
                        {{ $comment->body }}
                    </div>

                    {{-- Tombol hapus untuk pemilik komentar atau pemilik postingan --}}
                    @if (auth()->id() === $comment->user_id || auth()->id() === $post->user_id)
                        <form action="{{ route('posts.comment.destroy', [$post, $comment]) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-xs hover:underline">Hapus</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Form Komentar --}}
    <form action="{{ route('posts.comment', $post) }}" method="POST" class="mt-3">
        @csrf
        <input type="text" name="body" placeholder="Tulis komentar..."
            class="w-full text-sm border rounded px-3 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400">
    </form>
</div>

</div>
@endsection

@push('scripts')
<script>
function toggleDropdown(postId) {
    const dropdown = document.getElementById('dropdown-' + postId);
    dropdown.classList.toggle('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;

            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                this.dataset.liked = data.liked ? 'yes' : 'no';
                this.innerHTML = `${data.liked ? '❤️' : '🤍'} <span class="like-count">${data.count}</span> suka`;
            })
            .catch(error => console.error('Like error:', error));
        });
    });
});
</script>
@endpush
