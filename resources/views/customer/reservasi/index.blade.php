@extends('layouts.customer') {{-- Mengganti <x-app-layout> dengan layout customer --}}

@section('title', 'Riwayat Booking') {{-- Menambahkan Judul Halaman --}}

@section('content')
    <div class="py-0"> {{-- Menghilangkan py-12 agar padding diatur oleh layout utama --}}
        <div class="mx-auto space-y-8">

            {{-- HEADER --}}
            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-bold text-white">Riwayat Booking</h2>
                <p class="text-slate-400 mt-1">Pantau status pesanan lapanganmu di sini.</p>
            </div>

            {{-- TABLE CONTAINER --}}
            <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-xl mx-4 sm:mx-0">
                @if ($reservasis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-400">
                            {{-- Header Tabel --}}
                            <thead class="bg-slate-700/50 text-slate-200 uppercase text-xs font-semibold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Lapangan</th>
                                    <th class="px-6 py-4">Jadwal Main</th>
                                    <th class="px-6 py-4">Durasi</th>
                                    <th class="px-6 py-4">Total Harga</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    {{-- <th class="px-6 py-4 font-semibold text-right">Aksi</th> --}}
                                </tr>
                            </thead>
                            {{-- Body Tabel --}}
                            <tbody class="divide-y divide-slate-700">
                                @foreach ($reservasis as $reservasi)
                                    <tr class="hover:bg-slate-700/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-slate-700 flex items-center justify-center text-emerald-500">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-white">
                                                        {{ $reservasi->lapangan->nama ?? 'Lapangan Dihapus' }}</div>
                                                    <div class="text-xs text-slate-500">Booked on
                                                        {{ $reservasi->created_at->format('d M Y') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-white font-medium">
                                                {{ \Carbon\Carbon::parse($reservasi->tanggal_main)->format('d M Y') }}</div>
                                            <div class="text-slate-400 text-xs">
                                                {{ \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="px-6 py-4 text-white whitespace-nowrap">
                                            {{ $reservasi->durasi }} Jam
                                        </td>
                                        <td class="px-6 py-4 text-emerald-400 font-bold whitespace-nowrap">
                                            Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $statusClasses = [
                                                    'pending' =>
                                                        'bg-orange-500/10 text-orange-400 border-orange-500/20',
                                                    'confirmed' =>
                                                        'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                    'cancelled' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                                    'completed' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                ];
                                                $status = strtolower($reservasi->status);
                                                $class =
                                                    $statusClasses[$status] ??
                                                    'bg-slate-700 text-slate-400 border-slate-600';
                                            @endphp
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full border {{ $class }}">
                                                {{ ucfirst($reservasi->status) }}
                                            </span>
                                        </td>
                                        {{-- Kolom Aksi dihilangkan --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Konten Jika Kosong (sudah sesuai palet dark mode) --}}
                    <div class="flex flex-col items-center justify-center py-24 text-center">
                        <div class="w-20 h-20 bg-slate-700/50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Belum ada booking</h3>
                        <p class="text-slate-400 mb-6 max-w-sm">Kamu belum pernah melakukan reservasi. Yuk main futsal
                            bareng teman-teman!</p>
                        <a href="{{ route('lapangan.index') }}"
                            class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 transition">
                            Cari Lapangan
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
