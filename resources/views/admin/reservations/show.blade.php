@extends('layouts.admin')

@section('content')
<div class="p-6" x-data="{ showApproveModal: false, showRejectModal: false }">

    {{-- Header & Back Button --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Detail Reservasi #{{ $reservation->id }}</h1>
            <p class="text-slate-400">Tinjau detail booking dan konfirmasi pembayaran.</p>
        </div>
        <a href="{{ route('admin.reservations.index') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2">
            &larr; Kembali ke Daftar
        </a>
    </div>

    {{-- Notifikasi Sukses/Error --}}
    @if (session('success'))
    <div class="mb-6 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: DETAIL USER & BOOKING --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Customer --}}
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Data Customer</h3>
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-slate-700 rounded-full flex items-center justify-center text-emerald-500 font-bold text-xl">
                        {{ substr($reservation->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-white font-medium text-lg">{{ $reservation->user->name ?? 'User Terhapus' }}</h4>
                        <p class="text-slate-400 text-sm">{{ $reservation->user->email ?? '-' }}</p>
                        <div class="mt-2">
                            <a href="https://wa.me/{{ $reservation->user->phone ?? '' }}" target="_blank"
                                class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                                {{ $reservation->user->phone ?? 'No WA' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Lapangan & Waktu --}}
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Informasi Lapangan</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <dt class="text-slate-400 text-sm">Nama Lapangan</dt>
                        <dd class="text-white font-medium text-lg">{{ $reservation->field->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-400 text-sm">Status Saat Ini</dt>
                        <dd>
                            @php
                            $statusClasses = [
                            'pending' => 'text-orange-400 bg-orange-500/10 border-orange-500/20',
                            'paid' => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
                            'confirmed' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                            'cancelled' => 'text-red-400 bg-red-500/10 border-red-500/20',
                            ];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-sm font-bold rounded-lg border {{ $statusClasses[$reservation->status] ?? '' }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-slate-400 text-sm">Tanggal Booking</dt>
                        <dd class="text-white">{{ \Carbon\Carbon::parse($reservation->booking_date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-400 text-sm">Jam Sewa</dt>
                        <dd class="text-white">{{ $reservation->start_time }} - {{ $reservation->end_time }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-slate-400 text-sm">Total Harga</dt>
                        <dd class="text-3xl font-bold text-emerald-400">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</dd>
                    </div>

                    @if($reservation->rejection_reason)
                    <div class="md:col-span-2 bg-red-900/20 border border-red-900/50 p-4 rounded-xl">
                        <dt class="text-red-400 text-sm font-bold">Alasan Penolakan:</dt>
                        <dd class="text-white mt-1">{{ $reservation->rejection_reason }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        {{-- KOLOM KANAN: BUKTI BAYAR & AKSI --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Bukti Pembayaran --}}
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4">Bukti Pembayaran</h3>

                @if ($reservation->payment_proof)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $reservation->payment_proof) }}"
                        alt="Bukti Transfer"
                        class="w-full rounded-xl border border-slate-600 shadow-md object-cover">

                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded-xl cursor-pointer"
                        onclick="window.open('{{ asset('storage/' . $reservation->payment_proof) }}', '_blank')">
                        <span class="text-white font-medium bg-black/50 px-3 py-1 rounded-lg">Lihat Full</span>
                    </div>
                </div>
                <p class="text-center text-xs text-slate-500 mt-2">Klik gambar untuk memperbesar</p>
                @else
                <div class="bg-slate-900 rounded-xl p-8 text-center border border-slate-700 border-dashed">
                    <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-slate-400 text-sm">Bukti pembayaran belum diupload oleh customer.</p>
                </div>
                @endif
            </div>

            {{-- TOMBOL AKSI (Hanya muncul jika Pending/Paid) --}}
            @if ($reservation->status == 'pending' || $reservation->status == 'paid')
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4">Aksi Admin</h3>

                <div class="space-y-3">
                    {{-- Tombol Terima --}}
                    <button @click="showApproveModal = true"
                        class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Terima & Konfirmasi
                    </button>

                    {{-- Tombol Tolak --}}
                    <button @click="showRejectModal = true"
                        class="w-full bg-slate-700 hover:bg-red-600/90 text-white font-bold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2 border border-slate-600 hover:border-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak Reservasi
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- =================================== --}}
    {{-- MODAL APPROVE                       --}}
    {{-- =================================== --}}
    <div x-show="showApproveModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-approve-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showApproveModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 transition-opacity" @click="showApproveModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showApproveModal" x-transition.scale class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">

                <form method="POST" action="{{ route('admin.reservations.approve', $reservation->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-approve-title">Konfirmasi Reservasi</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-400">Pastikan bukti pembayaran valid. Reservasi akan diubah statusnya menjadi <b>Confirmed</b> dan notifikasi akan dikirim ke customer.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Ya, Konfirmasi</button>
                        <button type="button" @click="showApproveModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-600 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-slate-300 hover:bg-slate-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =================================== --}}
    {{-- MODAL REJECT                        --}}
    {{-- =================================== --}}
    <div x-show="showRejectModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-reject-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showRejectModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 transition-opacity" @click="showRejectModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showRejectModal" x-transition.scale class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">

                <form method="POST" action="{{ route('admin.reservations.reject', $reservation->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-reject-title">Tolak Reservasi</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-400 mb-3">Wajib mengisi alasan penolakan untuk memberitahu customer.</p>
                                    <textarea name="reason" rows="3" required
                                        class="w-full border border-slate-600 bg-slate-900 text-white rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 p-3 text-sm placeholder-slate-500"
                                        placeholder="Contoh: Maaf, bukti pembayaran buram / Lapangan sedang maintenance."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Tolak Booking</button>
                        <button type="button" @click="showRejectModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-600 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-slate-300 hover:bg-slate-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection