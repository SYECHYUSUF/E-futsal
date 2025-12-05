@extends('layouts.customer')

@section('title', 'Booking Lapangan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">

        {{-- ALERT ERROR (Validation / Session) --}}
        @if (session('error'))
        <div class="bg-red-800/50 border border-red-700 text-red-400 p-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-800/50 border border-red-700 text-red-400 p-4 rounded-xl mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI: INFO LAPANGAN & FORM --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- 1. BAGIAN GALERI FOTO --}}
                @if($field->galleries && $field->galleries->count() > 0)
                <div>
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Galeri Foto
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- Foto Utama (Thumbnail Kecil) --}}
                        @if($field->image)
                        <div class="relative aspect-square rounded-xl overflow-hidden border border-slate-700 group cursor-pointer">
                            <img src="{{ asset('storage/' . $field->image) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <span class="text-xs font-bold text-white bg-black/50 px-2 py-1 rounded">Utama</span>
                            </div>
                            <a href="{{ asset('storage/' . $field->image) }}" target="_blank" class="absolute inset-0 z-10"></a>
                        </div>
                        @endif

                        {{-- Loop Galeri Tambahan --}}
                        @foreach($field->galleries as $gallery)
                        <div class="relative aspect-square rounded-xl overflow-hidden border border-slate-700 group cursor-pointer">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition"></div>
                            <a href="{{ asset('storage/' . $gallery->image) }}" target="_blank" class="absolute inset-0 z-10"></a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- 2. BAGIAN FASILITAS --}}
                @if($field->facilities && $field->facilities->count() > 0)
                <div>
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Fasilitas Lapangan
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($field->facilities as $facility)
                        <div class="bg-slate-800 p-3 rounded-xl border border-slate-700 flex items-center gap-3 shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-slate-300 text-sm font-medium">{{ $facility->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- 3. FORMULIR RESERVASI --}}
                <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-xl">
                    <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-4">Isi Detail Booking</h2>

                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="field_id" value="{{ $field->id }}">

                        <div class="space-y-6">
                            {{-- Tanggal --}}
                            <div>
                                <label class="block text-slate-400 text-sm font-medium mb-2">Pilih Tanggal Main</label>
                                <input type="date" name="booking_date" id="booking_date"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors @error('booking_date') border-red-500 @enderror"
                                    min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required>
                                @error('booking_date')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jam --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-slate-400 text-sm font-medium mb-2">Jam Mulai</label>
                                    <select name="start_time" id="start_time"
                                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer @error('start_time') border-red-500 @enderror"
                                        required>
                                        <option value="">Pilih Jam</option>
                                        @for ($i = 8; $i < 24; $i++)
                                            <option value="{{ sprintf('%02d:00', $i) }}" {{ old('start_time') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                            {{ sprintf('%02d:00', $i) }}
                                            </option>
                                            @endfor
                                    </select>
                                    @error('start_time')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-slate-400 text-sm font-medium mb-2">Jam Selesai</label>
                                    <select name="end_time" id="end_time"
                                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer @error('end_time') border-red-500 @enderror"
                                        required>
                                        <option value="">Pilih Jam</option>
                                        @for ($i = 9; $i <= 24; $i++)
                                            <option value="{{ sprintf('%02d:00', $i) }}" {{ old('end_time') == sprintf('%02d:00', $i) ? 'selected' : '' }}>
                                            {{ sprintf('%02d:00', $i) }}
                                            </option>
                                            @endfor
                                    </select>
                                    @error('end_time')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit"
                                class="mt-4 w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/40 transform hover:-translate-y-0.5">
                                Konfirmasi Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN: RINGKASAN STICKY --}}
            <div class="lg:col-span-1">
                <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-xl sticky lg:top-8">
                    <h3 class="text-lg font-bold text-white mb-4">Ringkasan</h3>

                    <div class="flex items-start gap-4 mb-6 pb-6 border-b border-slate-700">
                        @if ($field->image)
                        <img src="{{ asset('storage/' . $field->image) }}" alt="{{ $field->name }}"
                            class="w-20 h-20 object-cover rounded-lg border border-slate-600">
                        @else
                        <div class="w-20 h-20 bg-slate-700 rounded-lg flex items-center justify-center text-slate-500 text-xs">
                            No Image
                        </div>
                        @endif
                        <div>
                            <h4 class="text-white font-bold text-lg leading-tight mb-1">{{ $field->name }}</h4>
                            <p class="text-slate-400 text-sm">
                                Rp {{ number_format($field->hourly_rate, 0, ',', '.') }} <span class="text-xs">/ jam</span>
                            </p>
                            <div class="mt-2 flex items-center gap-1 text-xs text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Kapasitas {{ $field->capacity }} Orang
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-end">
                            <span class="text-slate-400 font-medium">Total Bayar</span>
                            <span id="total-display" class="text-2xl font-bold text-emerald-400">Rp 0</span>
                        </div>
                        <p id="durasi-display" class="text-slate-500 text-sm text-right h-5"></p>

                        <input type="number" hidden id="hourly_rate" value="{{ $field->hourly_rate }}">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT PERHITUNGAN HARGA --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startInput = document.getElementById('start_time');
        const endInput = document.getElementById('end_time');
        const totalDisplay = document.getElementById('total-display');
        const durasiDisplay = document.getElementById('durasi-display');

        const hourlyRateInputValue = document.getElementById('hourly_rate').value;
        const hourlyRate = parseFloat(hourlyRateInputValue);

        function calculate() {
            const startVal = startInput.value;
            const endVal = endInput.value;

            if (startVal && endVal) {
                // Ambil angka jam saja (substring 0-2)
                const startHour = parseInt(startVal.substring(0, 2));
                const endHour = parseInt(endVal.substring(0, 2));

                let durasi = 0;

                if (endHour > startHour) {
                    // Kasus normal (Main jam 14 s/d 16) = 2 jam
                    durasi = endHour - startHour;
                } else if (endHour < startHour) {
                    // Kasus lintas hari (Main jam 23 s/d 01)
                    // (24 - 23) + 1 = 2 jam
                    durasi = (24 - startHour) + endHour;
                } else {
                    // Jam sama persis (Main jam 14 s/d 14) = 0 jam (invalid)
                    durasi = 0;
                }

                // Tampilkan Hasil
                if (durasi > 0) {
                    durasiDisplay.textContent = `Durasi: ${durasi} Jam`;
                    
                    // Hitung total (bulatkan durasi ke atas jika kebijakan anda membulatkan jam)
                    const total = Math.ceil(durasi) * hourlyRate;
                    
                    totalDisplay.textContent = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(total);

                    // Hapus error visual
                    startInput.classList.remove('border-red-500');
                    endInput.classList.remove('border-red-500');
                } else {
                    durasiDisplay.textContent = 'Durasi tidak valid';
                    totalDisplay.textContent = 'Rp 0';
                }
            } else {
                totalDisplay.textContent = 'Rp 0';
                durasiDisplay.textContent = '';
            }
        }

        startInput.addEventListener('change', calculate);
        endInput.addEventListener('change', calculate);

        // Jalankan saat load
        calculate();
    });
</script>
@endsection