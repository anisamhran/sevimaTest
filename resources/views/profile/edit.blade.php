@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-blue-600 mb-6">Edit Profil</h2>
        @if (session('status') === 'profile-updated')
            <div class="mb-4 text-green-600 font-semibold">Profil berhasil diperbarui.</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Foto Profil -->
            <div class="mb-6 text-center">
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                     alt="Foto Profil" 
                     class="w-24 h-24 mx-auto rounded-full object-cover mb-2 border border-gray-300 shadow">
                <input type="file" name="profile_picture" 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                              file:border-0 file:bg-blue-50 file:text-blue-700 file:rounded-full
                              file:cursor-pointer hover:file:bg-blue-100 mt-2">
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block font-medium text-sm">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="block font-medium text-sm">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" 
                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label for="bio" class="block font-medium text-sm">Bio</label>
                <textarea name="bio" id="bio" rows="3" 
                          class="mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <x-primary-button>Simpan Perubahan</x-primary-button>
            </div>
        </form>
    </div>
@endsection

