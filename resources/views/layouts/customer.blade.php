<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'eFutsal') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-900 text-slate-100 antialiased" x-data="{ sidebarOpen: false }">

    {{-- Mobile Header --}}
    <div
        class="flex h-16 items-center justify-between border-b border-slate-800 bg-slate-900 px-4 md:hidden sticky top-0 z-30">
        <a href="/" class="flex items-center gap-2 font-bold text-xl">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500 text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span>e<span class="text-emerald-500">Futsal</span></span>
        </a>
        <button @click="sidebarOpen = true" class="text-slate-400 hover:text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </div>

    <div class="flex min-h-screen overflow-hidden">

        {{-- Sidebar Navigasi --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-40 w-64 transform border-r border-slate-800 bg-slate-900 transition-transform duration-300 md:static md:translate-x-0">
            <div class="flex h-20 items-center justify-center border-b border-slate-800">
                <a href="/" class="flex items-center gap-2 text-2xl font-bold tracking-tighter">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 shadow-lg shadow-emerald-600/20 text-white">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span>e<span class="text-emerald-500">Futsal</span></span>
                </a>
            </div>

            <div class="flex flex-col justify-between h-[calc(100vh-5rem)] overflow-y-auto py-6 px-4">
                <nav class="space-y-1">
                    
                    {{-- 1. Dashboard (Auth Only) --}}
                    @auth
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    @endauth

                    {{-- 2. Cari Lapangan --}}
                    <a href="{{ route('customer.fields.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('customer.fields.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Cari Lapangan</span>
                    </a>

                    {{-- 3. Riwayat Booking (Auth Only) --}}
                    @auth
                    <a href="{{ route('reservations.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('reservations.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span class="font-medium">Riwayat Booking</span>
                    </a>

                    {{-- 4. Profil (Auth Only) --}}
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">Profil</span>
                    </a>
                    @endauth

                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Info</p>
                    </div>

                    {{-- 5. Tentang Kami --}}
                    <a href="{{ route('about') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('about') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Tentang Kami</span>
                    </a>

                    {{-- 6. Kontak --}}
                    <a href="{{ route('contact') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('contact') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">Kontak</span>
                    </a>
                </nav>

                {{-- Footer Sidebar: Login/Logout --}}
                <div class="border-t border-slate-800 pt-4">
                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" 
                        class="flex w-full items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 shadow-lg shadow-emerald-600/20 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-bold">Login / Register</span>
                    </a>
                    @endauth
                </div>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 z-30 bg-slate-900/80 backdrop-blur-sm md:hidden"></div>

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header Utama --}}
            <header class="flex items-center justify-end border-b border-slate-800 bg-slate-900 px-6 py-4 shadow-sm">
                <div class="flex items-center gap-4">
                    
                    {{-- CEK APAKAH LOGIN ATAU TIDAK --}}
                    @auth
                        <div class="hidden md:flex flex-col items-end">
                            <span class="text-sm font-bold text-white">{{ Auth::user()->name }}</span>
                            <span class="text-xs text-emerald-400">Customer</span>
                        </div>
                        <div
                            class="h-10 w-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-emerald-500 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @else
                        {{-- Tampilan untuk Guest (Belum Login) --}}
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-slate-400 hidden sm:block">Selamat Datang, Tamu!</span>
                            <a href="{{ route('login') }}" class="text-sm font-bold text-emerald-400 hover:text-emerald-300 transition border border-emerald-500/50 px-4 py-2 rounded-lg hover:bg-emerald-500/10">
                                Login
                            </a>
                        </div>
                    @endauth

                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-slate-900 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html> 