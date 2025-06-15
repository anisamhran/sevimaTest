<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'InstaApp')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-6 hidden md:block sticky top-0 h-screen">
            <h1 class="text-2xl font-bold text-blue-500">InstaApp</h1>
            <div class="relative">
                <input
                    type="text"
                    id="live-search"
                    placeholder="Cari pengguna..."
                    class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring focus:border-blue-300"
                >
            
                <ul id="search-results" class="absolute z-50 w-full bg-white border mt-1 rounded-md shadow hidden">
                    <!-- Hasil pencarian akan muncul di sini -->
                </ul>
            </div>
            
            
            <nav class="space-y-4 mt-8 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:text-blue-500">
                    <i data-lucide="home" class="w-5 h-5"></i> Beranda
                </a>
                <a href="{{ route('explore') }}" class="flex items-center gap-2 hover:text-blue-500">
                    <i data-lucide="search" class="w-5 h-5"></i> Jelajahi
                </a>
            
                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp
                <a href="{{ route('notifications') }}" class="relative flex items-center gap-2 hover:text-blue-500">
                    <i data-lucide="bell" class="w-5 h-5"></i> Notifikasi
                    @if ($unreadCount > 0)
                        <span class="absolute top-0 right-0 -mt-1 -mr-2 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            
                <a href="{{ route('posts.create') }}" class="flex items-center gap-2 hover:text-blue-500">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i> Buat Postingan
                </a>
                <a href="{{ route('profile.me') }}" class="flex items-center gap-2 hover:text-blue-500">
                    <i data-lucide="user" class="w-5 h-5"></i> Profil Saya
                </a>
            
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="flex items-center gap-2 text-left w-full hover:text-red-500">
                        <i data-lucide="log-out" class="w-5 h-5"></i> Keluar
                    </button>
                </form>
            </nav>
            
            
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>


        <!-- Right Sidebar -->
        <!-- Right Sidebar -->
@auth
@php 
    $user = auth()->user(); 
    $hideRightSidebar = in_array(Route::currentRouteName(), ['profile.me', 'profile.edit']);
@endphp

@unless ($hideRightSidebar)
    <aside class="w-72 hidden lg:block ml-6 pt-10 sticky top-0 h-screen">
        {{-- User Info --}}
        <div class="flex items-center space-x-4 mb-6">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                 alt="Avatar" class="w-10 h-10 rounded-full object-cover">
            <div>
                <p class="font-semibold">{{ $user->username }}</p>
                <p class="text-sm text-gray-500">{{ $user->name }}</p>
            </div>
        </div>

        {{-- Placeholder --}}
        <p class="text-gray-400 text-sm">Rekomendasi pengguna nanti di sini</p>
    </aside>
@endunless
@endauth

    </div>


    <script>
        function confirmLogout() {
            if (confirm('Yakin ingin keluar dari akun?')) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
    
    @stack('scripts')

</body>
<script>
    lucide.createIcons();
</script>

</html>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('live-search');
        const resultsBox = document.getElementById('search-results');

        input.addEventListener('input', function () {
            const query = this.value;

            if (query.length < 2) {
                resultsBox.classList.add('hidden');
                resultsBox.innerHTML = '';
                return;
            }

            fetch(`/search/users?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsBox.innerHTML = '';
                    if (data.length === 0) {
                        resultsBox.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500">Tidak ditemukan.</li>';
                    } else {
                        data.forEach(user => {
                            const li = document.createElement('li');
                            li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center gap-3';
                            li.innerHTML = `
                                <img src="${user.profile_picture ? '/storage/' + user.profile_picture : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name)}"
                                     class="w-6 h-6 rounded-full object-cover">
                                <div>
                                    <div class="font-semibold text-sm">${user.name}</div>
                                    <div class="text-xs text-gray-500">@${user.username}</div>
                                </div>
                            `;
                            li.onclick = () => window.location.href = `/user/${user.username}`;
                            resultsBox.appendChild(li);
                        });
                    }
                    resultsBox.classList.remove('hidden');
                });
        });

        // Optional: hide results when clicking outside
        document.addEventListener('click', function (e) {
            if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.add('hidden');
            }
        });
    });
</script>
