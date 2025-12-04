@extends('layouts.admin') {{-- Pastikan layout ini tersedia --}}

@section('content')
<div class="p-6">
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Tambah Lapangan Baru</h1>
        <a href="{{ route('admin.lapangan.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">
            &larr; Kembali ke Daftar Lapangan
        </a>
    </div>

    <div class="max-w-4xl bg-slate-800 p-8 rounded-2xl border border-slate-700 shadow-lg">
        
        {{-- Form ini akan dikirim ke method store di Admin\LapanganController --}}
        {{-- enctype="multipart/form-data" diperlukan karena ada input file (gambar) --}}
        <form action="{{ route('admin.lapangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                
                {{-- Nama Lapangan --}}
                <div>
                    <label for="nama" class="block text-slate-400 text-sm font-medium mb-2">Nama Lapangan</label>
                    <input type="text" name="nama" id="nama" 
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500" 
                           value="{{ old('nama') }}" required>
                    @error('nama')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kapasitas --}}
                <div>
                    <label for="kapasitas" class="block text-slate-400 text-sm font-medium mb-2">Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" id="kapasitas" 
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500" 
                           value="{{ old('kapasitas') }}" required min="1">
                    @error('kapasitas')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Biaya Per Jam --}}
                <div>
                    <label for="biaya_per_jam" class="block text-slate-400 text-sm font-medium mb-2">Biaya Per Jam (Rp)</label>
                    <input type="number" name="biaya_per_jam" id="biaya_per_jam" 
                           class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500" 
                           value="{{ old('biaya_per_jam') }}" required min="1000">
                    @error('biaya_per_jam')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar Lapangan --}}
                <div>
                    <label for="gambar" class="block text-slate-400 text-sm font-medium mb-2">Gambar Lapangan</label>
                    <input type="file" name="gambar" id="gambar" 
                           class="w-full file:bg-emerald-600 file:text-white file:border-none file:py-2 file:px-4 file:rounded-xl file:cursor-pointer file:hover:bg-emerald-500 file:transition file:mr-4
                                  bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500" 
                           accept="image/*">
                    @error('gambar')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Simpan --}}
            <button type="submit" class="mt-8 px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl transition-colors shadow-lg shadow-emerald-600/30">
                Simpan Lapangan
            </button>
        </form>
    </div>
</div>
@endsection