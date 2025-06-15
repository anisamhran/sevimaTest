@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-xl mx-auto space-y-4">
    <h2 class="text-2xl font-bold mb-4">Notifikasi</h2>

    @forelse ($notifications as $notif)
    <div class="bg-white p-4 rounded-lg shadow text-sm">
        @if ($notif->data['type'] === 'like')
            <p><strong>{{ $notif->data['from_user_name'] }}</strong> menyukai postinganmu.</p>
        @elseif ($notif->data['type'] === 'comment')
            <p><strong>{{ $notif->data['from_user_name'] }}</strong> mengomentari: "{{ $notif->data['body'] }}"</p>
        @endif
        <p class="text-gray-400 text-xs mt-1">{{ $notif->created_at->diffForHumans() }}</p>
    </div>
@empty
    <p class="text-gray-500 text-center">Belum ada notifikasi.</p>
@endforelse

</div>
@endsection
