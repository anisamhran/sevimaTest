@extends('layouts.app')

@section('title', 'Buat Postingan')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">Buat Postingan Baru</h2>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full">
            @error('image') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="caption" class="block text-sm font-medium text-gray-700">Caption</label>
            <textarea name="caption" id="caption" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('caption') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Upload
            </button>
        </div>
    </form>
</div>
@endsection
