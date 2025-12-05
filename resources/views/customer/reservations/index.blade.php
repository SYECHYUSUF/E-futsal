@extends('layouts.customer')

@section('title', 'Riwayat Booking')

@section('content')
<div class="py-0">
    <div class="mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="mb-8 px-4 sm:px-0">
            <h2 class="text-3xl font-bold text-white">Riwayat Booking</h2>
            <p class="text-slate-400 mt-1">Pantau status pesanan lapanganmu di sini.</p>
        </div>

        {{-- ALERT MESSAGES --}}
        @if (session('success'))
        <div class="mb-4 mx-4 sm:mx-0 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-lg relative"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- TABLE CONTAINER --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-xl mx-4 sm:mx-0">
            {{-- Gunakan variabel $reservations (dari controller) --}}
            @if ($reservations->count() > 0)
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
                            {{-- Tambahkan Kolom Aksi --}}
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- Body Tabel --}}
                    <tbody class="divide-y divide-slate-700">
                        @foreach ($reservations as $reservation)
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
                                        {{-- Relasi: field, Kolom: name --}}
                                        <div class="font-bold text-white">
                                            {{ $reservation->field->name ?? 'Lapangan Dihapus' }}
                                        </div>
                                        <div class="text-xs text-slate-500">Booked on
                                            {{ $reservation->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- Kolom: booking_date --}}
                                <div class="text-white font-medium">
                                    {{ \Carbon\Carbon::parse($reservation->booking_date)->format('d M Y') }}
                                </div>
                                {{-- Kolom: start_time & end_time --}}
                                <div class="text-slate-400 text-xs">
                                    {{ $reservation->start_time }} - {{ $reservation->end_time }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-white whitespace-nowrap">
                                {{-- Menghitung Durasi Manual --}}
                                @php
                                $start = \Carbon\Carbon::parse($reservation->start_time);
                                $end = \Carbon\Carbon::parse($reservation->end_time);
                                if ($end->lessThan($start)) {
                                $end->addDay();
                                }
                                $durasi = $end->diffInHours($start);
                                @endphp
                                {{ $durasi }} Jam
                            </td>
                            <td class="px-6 py-4 text-emerald-400 font-bold whitespace-nowrap">
                                Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                            </td>

                            {{-- LOGIKA STATUS --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                $statusLabel = ucfirst($reservation->status);
                                $statusClass = 'bg-slate-700 text-slate-400 border-slate-600'; // Default

                                if ($reservation->status == 'pending') {
                                if (!$reservation->payment_proof) {
                                // Pending & Belum Upload Bukti
                                $statusLabel = 'Menunggu Pembayaran';
                                $statusClass = 'bg-red-500/10 text-red-400 border-red-500/20 animate-pulse';
                                } else {
                                // Pending & Sudah Upload Bukti
                                $statusLabel = 'Menunggu Konfirmasi';
                                $statusClass = 'bg-orange-500/10 text-orange-400 border-orange-500/20';
                                }
                                } elseif ($reservation->status == 'paid') {
                                $statusLabel = 'Sudah Dibayar';
                                $statusClass = 'bg-blue-500/10 text-blue-400 border-blue-500/20';
                                } elseif ($reservation->status == 'confirmed') {
                                $statusClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                                } elseif ($reservation->status == 'cancelled') {
                                $statusClass = 'bg-slate-700 text-slate-500 border-slate-600';
                                }
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full border {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- TOMBOL AKSI --}}
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('reservations.show', $reservation->id) }}"
                                    class="text-blue-400 hover:text-blue-300 font-bold text-sm bg-blue-500/10 px-4 py-2 rounded-lg border border-blue-500/20 hover:bg-blue-500/20 transition-all">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            {{-- Konten Jika Kosong --}}
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
                {{-- Route: customer.fields.index --}}
                <a href="{{ route('customer.fields.index') }}"
                    class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 transition">
                    Cari Lapangan
                </a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection