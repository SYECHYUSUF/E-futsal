@extends('layouts.customer')

@section('title', 'Detail Reservasi #' . $reservation->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">

        {{-- HEADER & BACK BUTTON --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Detail Reservasi #{{ $reservation->id }}</h1>
                <p class="text-slate-400 text-sm">Dibuat pada {{ $reservation->created_at->format('d M Y, H:i') }}</p>
            </div>
            <a href="{{ route('reservations.index') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2">
                &larr; Kembali
            </a>
        </div>

        {{-- ALERT SUKSES --}}
        @if (session('success'))
        <div class="mb-6 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
        @endif

        {{-- ALERT ALASAN DITOLAK --}}
        @if ($reservation->status == 'cancelled' && $reservation->rejection_reason)
        <div class="mb-6 bg-red-900/50 border border-red-700 p-6 rounded-2xl flex items-start gap-4">
            <div class="p-2 bg-red-800 rounded-lg text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-red-400">Reservasi Ditolak Admin</h3>
                <p class="text-slate-300 mt-1">Alasan: "{{ $reservation->rejection_reason }}"</p>
                <p class="text-slate-400 text-sm mt-2">Silakan buat booking baru di jam/tanggal lain.</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- KOLOM KIRI: INFO DETAIL --}}
            <div class="space-y-6">
                {{-- Status Card --}}
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
                    <h3 class="text-sm font-medium text-slate-400 mb-4">Status Reservasi</h3>
                    @php
                    $statusClasses = [
                    'pending' => 'bg-orange-500/20 text-orange-400 border-orange-500/30',
                    'paid' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                    'confirmed' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                    'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
                    ];
                    @endphp
                    <div class="inline-flex items-center px-4 py-2 rounded-xl border {{ $statusClasses[$reservation->status] ?? 'bg-slate-700 text-slate-300' }}">
                        <span class="font-bold uppercase tracking-wide">{{ $reservation->status }}</span>
                    </div>
                </div>

                {{-- Detail Lapangan --}}
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Informasi Booking</h3>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-slate-400">Lapangan</dt>
                            <dd class="text-white font-medium text-lg">{{ $reservation->field->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-400">Tanggal Main</dt>
                            <dd class="text-white font-medium">
                                {{ \Carbon\Carbon::parse($reservation->booking_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </dd>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm text-slate-400">Jam Mulai</dt>
                                <dd class="text-white font-medium">{{ $reservation->start_time }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-400">Jam Selesai</dt>
                                <dd class="text-white font-medium">{{ $reservation->end_time }}</dd>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-400">Total Biaya</dt>
                            <dd class="text-2xl font-bold text-emerald-400">
                                Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- KOLOM KANAN: BUKTI PEMBAYARAN --}}
            <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg h-fit">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Bukti Pembayaran</h3>

                @if ($reservation->payment_proof)
                {{-- Jika sudah upload --}}
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $reservation->payment_proof) }}"
                        alt="Bukti Bayar"
                        class="w-full rounded-xl border border-slate-600 shadow-sm cursor-pointer hover:opacity-90 transition"
                        onclick="window.open(this.src, '_blank')">
                    <p class="text-xs text-center text-slate-500 mt-2">Klik gambar untuk memperbesar</p>
                </div>

                @if ($reservation->status == 'pending' || $reservation->status == 'paid')
                <div class="p-3 bg-blue-900/30 border border-blue-800 rounded-xl text-center">
                    <p class="text-blue-300 text-sm">Bukti pembayaran telah dikirim. <br>Mohon tunggu konfirmasi admin.</p>
                </div>
                @endif

                @else
                {{-- Jika belum upload --}}
                <div class="text-center py-6">
                    <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-400 mb-6">Belum ada bukti pembayaran yang diunggah.</p>

                    @if ($reservation->status != 'cancelled')
                    <form action="{{ route('reservations.payment', $reservation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4 text-left">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Upload Bukti Transfer</label>
                            <input type="file" name="payment_proof" required
                                class="block w-full text-sm text-slate-400
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-emerald-600 file:text-white
                                            file:cursor-pointer hover:file:bg-emerald-700
                                            bg-slate-900 rounded-lg border border-slate-600 focus:outline-none">
                            @error('payment_proof')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-emerald-600/20">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                    @else
                    <p class="text-red-400 text-sm font-bold">Booking Dibatalkan. Tidak perlu upload pembayaran.</p>
                    @endif
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection