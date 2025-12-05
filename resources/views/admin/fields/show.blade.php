@extends('layouts.admin')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Detail Lapangan: {{ $field->name }}</h1>
            <p class="text-slate-400">Statistik performa dan informasi detail fasilitas.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.fields.index') }}" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition">
                &larr; Kembali
            </a>
            <a href="{{ route('admin.fields.edit', $field->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-500 transition">
                Edit Lapangan
            </a>
        </div>
    </div>

    {{-- STATS CARDS (GRID) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Card 1: Total Pendapatan --}}
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-slate-400 text-sm font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-emerald-400 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div class="absolute right-4 top-4 text-emerald-500/10">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.15-1.46-3.27-3.4h1.96c.1 1.05 1.18 1.91 2.53 1.91 1.29 0 2.13-.77 2.13-2.11 0-2.9-5.4-1.54-5.4-5.85 0-1.74 1.2-3.22 3.05-3.55V3h2.67v1.95c1.46.34 2.68 1.45 2.82 2.96h-1.97c-.12-.89-.95-1.48-1.99-1.48-1.2 0-1.92.83-1.92 1.84 0 2.96 5.39 1.63 5.39 5.8 0 1.76-1.25 3.23-3.13 3.57z" />
                </svg>
            </div>
        </div>

        {{-- Card 2: Total Booking --}}
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-medium">Total Kali Disewa</p>
            <h3 class="text-2xl font-bold text-white mt-1">{{ $totalBookings }} <span class="text-sm font-normal text-slate-500">Reservasi</span></h3>
        </div>

        {{-- Card 3: Tarif --}}
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
            <p class="text-slate-400 text-sm font-medium">Tarif Saat Ini</p>
            <h3 class="text-2xl font-bold text-blue-400 mt-1">Rp {{ number_format($field->hourly_rate, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500">/ jam</span></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: INFO & GALERI --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Foto Utama & Info Dasar --}}
            <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-lg">
                <div class="aspect-video w-full bg-slate-900 relative">
                    @if($field->image)
                    <img src="{{ asset('storage/' . $field->image) }}" class="w-full h-full object-cover">
                    @else
                    <div class="flex items-center justify-center h-full text-slate-500">No Image</div>
                    @endif
                    <div class="absolute top-4 right-4 bg-black/60 backdrop-blur-md px-3 py-1 rounded-lg text-white text-xs font-bold uppercase">
                        Kapasitas: {{ $field->capacity }} Orang
                    </div>
                </div>
            </div>

            {{-- Fasilitas --}}
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4">Fasilitas Tersedia</h3>
                @if($field->facilities->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($field->facilities as $facility)
                    <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-xl border border-slate-700">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-slate-300 text-sm">{{ $facility->name }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-slate-500 italic">Belum ada fasilitas yang ditambahkan.</p>
                @endif
            </div>

            {{-- Galeri Tambahan --}}
            @if($field->galleries->count() > 0)
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4">Galeri Foto</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($field->galleries as $gallery)
                    <div class="aspect-square rounded-xl overflow-hidden border border-slate-700 cursor-pointer group relative">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transition group-hover:scale-110">
                        <a href="{{ asset('storage/' . $gallery->image) }}" target="_blank" class="absolute inset-0 z-10"></a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- KOLOM KANAN: JADWAL UPCOMING --}}
        <div class="lg:col-span-1">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 shadow-lg sticky top-6">
                <h3 class="text-lg font-bold text-white mb-4">Jadwal Mendatang</h3>

                @if($upcomingBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingBookings as $booking)
                    <div class="p-4 bg-slate-700/30 rounded-xl border border-slate-700 hover:border-slate-500 transition">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-emerald-400 text-xs font-bold uppercase tracking-wider bg-emerald-500/10 px-2 py-1 rounded">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M') }}
                            </span>
                            <span class="text-slate-400 text-xs">{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                        </div>
                        <h4 class="text-white font-bold">{{ $booking->user->name ?? 'Guest' }}</h4>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-xs text-slate-500">Status: {{ ucfirst($booking->status) }}</span>
                            <a href="{{ route('admin.reservations.show', $booking->id) }}" class="text-blue-400 text-xs hover:underline">Detail &rarr;</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.reservations.index') }}" class="text-sm text-slate-400 hover:text-white transition">Lihat semua jadwal</a>
                </div>
                @else
                <div class="text-center py-8">
                    <p class="text-slate-500">Belum ada jadwal upcoming untuk lapangan ini.</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection