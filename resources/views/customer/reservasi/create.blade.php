@extends('layouts.customer')

@section('title', 'Booking Lapangan') {{-- Tambahkan title --}}

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">

            @if (session('error'))
                <div class="bg-red-800/50 border border-red-700 text-red-400 p-4 rounded-lg mb-6">{{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                {{-- Menampilkan error validasi Laravel di bagian atas --}}
                <div class="bg-red-800/50 border border-red-700 text-red-400 p-4 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: FORMULIR --}}
                <div class="lg:col-span-2">
                    <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-xl">
                        <h2 class="text-2xl font-bold text-white mb-6">Detail Reservasi</h2>

                        <form action="{{ route('reservasi.store') }}" method="POST">
                            @csrf

                            {{-- 1. DATA LAPANGAN (HIDDEN) --}}
                            <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

                            <div class="space-y-6">

                                {{-- Tanggal --}}
                                <div>
                                    <label class="block text-slate-400 text-sm font-medium mb-2">Pilih Tanggal Main</label>
                                    <input type="date" name="tanggal_booking" id="tanggal_booking"
                                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 @error('tanggal_booking') border-red-500 @enderror"
                                        min="{{ date('Y-m-d') }}" value="{{ old('tanggal_booking') }}" required>
                                    @error('tanggal_booking')
                                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Jam --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-slate-400 text-sm font-medium mb-2">Jam Mulai</label>
                                        <select name="jam_mulai" id="jam_mulai"
                                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 @error('jam_mulai') border-red-500 @enderror"
                                            required>
                                            <option value="">Pilih Jam</option>
                                            @for ($i = 8; $i < 24; $i++)
                                                <option value="{{ sprintf('%02d:00', $i) }}"
                                                    {{ old('jam_mulai') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d:00', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('jam_mulai')
                                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-slate-400 text-sm font-medium mb-2">Jam Selesai</label>
                                        <select name="jam_selesai" id="jam_selesai"
                                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 @error('jam_selesai') border-red-500 @enderror"
                                            required>
                                            <option value="">Pilih Jam</option>
                                            @for ($i = 9; $i <= 24; $i++)
                                                <option value="{{ sprintf('%02d:00', $i) }}"
                                                    {{ old('jam_selesai') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d:00', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('jam_selesai')
                                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit"
                                    class="mt-8 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-colors shadow-lg shadow-blue-600/20">
                                    Konfirmasi Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN BOOKING --}}
                <div class="lg:col-span-1">
                    <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-xl sticky lg:top-8">
                        <h3 class="text-lg font-bold text-white mb-4">Ringkasan</h3>

                        <div class="flex items-start gap-4 mb-6 pb-6 border-b border-slate-700">
                            {{-- Menampilkan Info Lapangan --}}
                            @if ($lapangan->gambar)
                                <img src="{{ asset('storage/' . $lapangan->gambar) }}" alt="{{ $lapangan->nama }}"
                                    class="w-20 h-20 object-cover rounded-lg border border-slate-700">
                            @else
                                <div
                                    class="w-20 h-20 bg-slate-700 rounded-lg flex items-center justify-center text-slate-500 text-xs">
                                    No Image</div>
                            @endif
                            <div>
                                <h4 class="text-white font-medium">{{ $lapangan->nama }}</h4>
                                <p class="text-slate-400 text-sm">Rp
                                    {{ number_format($lapangan->biaya_per_jam, 0, ',', '.') }} / jam</p>
                            </div>
                        </div>

                        <div class="pt-4">
                            <div class="flex justify-between items-end">
                                <span class="text-slate-400 font-medium">Total Bayar</span>
                                <span id="total-display" class="text-2xl font-bold text-blue-400">Rp 0</span>
                            </div>
                            <p id="durasi-display" class="text-slate-500 text-sm mt-1 text-right"></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK HITUNG HARGA REAL-TIME --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startInput = document.getElementById('jam_mulai');
            const endInput = document.getElementById('jam_selesai');
            const totalDisplay = document.getElementById('total-display');
            const durasiDisplay = document.getElementById('durasi-display');
            const biayaPerJam = {{ $lapangan->biaya_per_jam }};

            function calculate() {
                // Ambil jam dalam format 24 jam (misalnya '08:00' -> 8)
                const startHour = parseInt(startInput.value.substring(0, 2));
                const endHour = parseInt(endInput.value.substring(0, 2));

                let durasi = 0;

                if (startHour && endHour) {
                    // Kasus 1: Normal (09:00 - 12:00) atau 23:00 - 24:00 (00:00 hari berikutnya)
                    if (endHour > startHour) {
                        durasi = endHour - startHour;
                    }
                    // Kasus 2: Lintas Hari (23:00 - 01:00). JS menganggap 01 < 23.
                    // Jika jam selesai lebih kecil dari jam mulai, asumsikan itu adalah hari berikutnya.
                    else if (endHour < startHour) {
                        // Contoh: 23 ke 01. (24 - 23) + 1 = 2 jam
                        durasi = (24 - startHour) + endHour;
                    }
                    // Kasus 3: Jam Mulai = Jam Selesai (Tidak Valid, durasi 0)
                    else {
                        durasi = 0;
                    }

                    // Tampilkan durasi di bawah total
                    durasiDisplay.textContent = durasi > 0 ? `Durasi: ${durasi} Jam` : '';

                    if (durasi >= 1) {
                        const total = durasi * biayaPerJam;
                        // Format Rupiah
                        totalDisplay.textContent = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(total);
                    } else {
                        totalDisplay.textContent = 'Rp 0';
                    }
                } else {
                    totalDisplay.textContent = 'Rp 0';
                    durasiDisplay.textContent = '';
                }
            }

            // Panggil fungsi hitung setiap kali jam berubah
            startInput.addEventListener('change', calculate);
            endInput.addEventListener('change', calculate);

            // Panggil sekali saat load untuk menampilkan nilai lama jika ada error validasi
            calculate();
        });
    </script>
@endsection
