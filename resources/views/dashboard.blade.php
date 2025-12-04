@extends('layouts.customer') {{-- Pastikan nama layout file-nya benar (e.g., customer, atau layouts.customer) --}}

@section('title', 'Dashboard')

@section('content')
    <div class="py-0"> {{-- Hapus padding vertikal karena sudah ada di layout --}}
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- WELCOME CARD --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-600 shadow-xl">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 rounded-full bg-white opacity-10 blur-3xl"></div>
                <div class="relative p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-4">
                        <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h2>
                        <p class="text-emerald-100 text-lg max-w-xl">
                            Siap untuk mencetak gol hari ini? Cek jadwal lapangan favoritmu sekarang.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('lapangan.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-white text-emerald-700 font-bold rounded-xl hover:bg-emerald-50 transition shadow-lg">
                                Booking Lapangan
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div
                            class="w-32 h-32 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30 shadow-inner">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INFORMASI CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card Riwayat Booking --}}
                <div
                    class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg hover:border-emerald-500/50 transition duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-500/10 rounded-xl group-hover:bg-blue-500/20 transition">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-medium">Riwayat Booking</p>
                            <h3 class="text-2xl font-bold text-white">Status</h3>
                        </div>
                    </div>
                    <a href="{{ route('reservasi.index') }}"
                        class="mt-4 block text-sm text-blue-400 font-medium hover:text-blue-300">Lihat Riwayat &rarr;</a>
                </div>

                {{-- Card Cari Lapangan --}}
                <div
                    class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg hover:border-emerald-500/50 transition duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-emerald-500/10 rounded-xl group-hover:bg-emerald-500/20 transition">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-medium">Booking Baru</p>
                            <h3 class="text-2xl font-bold text-white">Cari Lapangan</h3>
                        </div>
                    </div>
                    <a href="{{ route('lapangan.index') }}"
                        class="mt-4 block text-sm text-emerald-400 font-medium hover:text-emerald-300">Lihat Daftar Lapangan
                        &rarr;</a>
                </div>

                {{-- Card Profil Kamu --}}
                <div
                    class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg hover:border-purple-500/50 transition duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-500/10 rounded-xl group-hover:bg-purple-500/20 transition">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-medium">Profil Kamu</p>
                            <h3 class="text-2xl font-bold text-white">Pengaturan</h3>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="mt-4 block text-sm text-purple-400 font-medium hover:text-purple-300">Edit Profil &rarr;</a>
                </div>
            </div>

        </div>
    </div>
@endsection
