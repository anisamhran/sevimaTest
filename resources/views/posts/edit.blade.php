@extends('layouts.app')

@section('title', 'Edit Postingan')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Edit Postingan</h2>

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Caption --}}
            <div class="mb-4">
                <label for="caption" class="block text-sm font-medium text-gray-700">Caption</label>
                <textarea name="caption" id="caption" rows="3"
                          class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                          required>{{ old('caption', $post->caption) }}</textarea>
                @error('caption')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar Saat Ini --}}
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Postingan" class="w-full max-h-64 object-cover rounded">
            </div>

            {{-- Ganti Gambar --}}
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Ganti Gambar (opsional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="mt-1 text-sm text-gray-600">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline mr-4">Batal</a>
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
