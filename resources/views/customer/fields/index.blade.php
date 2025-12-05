@extends('layouts.customer')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-white mb-8">Pilih Lapangan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {{-- Menggunakan variable $fields --}}
        @forelse($fields as $field)
        <div class="bg-slate-800 rounded-2xl overflow-hidden shadow-xl border border-slate-700">

            {{-- Gambar Lapangan (Attribute: image) --}}
            <img src="{{ asset('storage/' . $field->image) }}" alt="{{ $field->name }}"
                class="w-full h-48 object-cover">

            <div class="p-6">
                {{-- Nama Lapangan (Attribute: name) --}}
                <h2 class="text-xl font-bold text-white mb-2">{{ $field->name }}</h2>

                {{-- Kapasitas (Attribute: capacity) --}}
                <p class="text-slate-400 text-sm mb-4">Kapasitas: {{ $field->capacity }} orang</p>

                <div class="text-2xl font-semibold text-emerald-400 mb-4">
                    {{-- Harga (Attribute: hourly_rate) --}}
                    Rp {{ number_format($field->hourly_rate, 0, ',', '.') }} <span
                        class="text-base text-slate-500">/ jam</span>
                </div>

                {{-- Tombol Booking --}}
                {{-- Route: reservations.create | Parameter: field_id --}}
                <a href="{{ route('reservations.create', ['field_id' => $field->id]) }}"
                    class="block w-full text-center bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl transition-colors">
                    Booking Sekarang
                </a>
            </div>
        </div>
        @empty
        <p class="text-center text-slate-400 col-span-full">Belum ada lapangan yang terdaftar saat ini.</p>
        @endforelse
    </div>
</div>
@endsection