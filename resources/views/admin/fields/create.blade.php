@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Tambah Lapangan Baru</h1>
        {{-- Route kembali ke index fields --}}
        <a href="{{ route('admin.fields.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">
            &larr; Kembali ke Daftar Lapangan
        </a>
    </div>

    <div class="max-w-4xl bg-slate-800 p-8 rounded-2xl border border-slate-700 shadow-lg">

        {{-- Form action diarahkan ke admin.fields.store --}}
        <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">

                {{-- Nama Lapangan (Input: name) --}}
                <div>
                    <label for="name" class="block text-slate-400 text-sm font-medium mb-2">Nama Lapangan</label>
                    <input type="text" name="name" id="name"
                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500"
                        value="{{ old('name') }}" required>
                    @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kapasitas (Input: capacity) --}}
                <div>
                    <label for="capacity" class="block text-slate-400 text-sm font-medium mb-2">Kapasitas (Orang)</label>
                    <input type="number" name="capacity" id="capacity"
                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500"
                        value="{{ old('capacity') }}" required min="1">
                    @error('capacity')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Biaya Per Jam (Input: hourly_rate) --}}
                <div>
                    <label for="hourly_rate" class="block text-slate-400 text-sm font-medium mb-2">Biaya Per Jam (Rp)</label>
                    <input type="number" name="hourly_rate" id="hourly_rate"
                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500"
                        value="{{ old('hourly_rate') }}" required min="1000">
                    @error('hourly_rate')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gambar Lapangan (Input: image) --}}
                <div>
                    <label for="image" class="block text-slate-400 text-sm font-medium mb-2">Gambar Lapangan</label>
                    <input type="file" name="image" id="image"
                        class="w-full file:bg-emerald-600 file:text-white file:border-none file:py-2 file:px-4 file:rounded-xl file:cursor-pointer file:hover:bg-emerald-500 file:transition file:mr-4
                                  bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500"
                        accept="image/*">
                    @error('image')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- INPUT FASILITAS --}}
                <div>
                    <label class="block text-slate-400 text-sm font-medium mb-2">Fasilitas (Pisahkan dengan koma)</label>
                    <input type="text" name="facilities"
                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-600 focus:outline-none focus:border-emerald-500"
                        placeholder="Contoh: Wifi Gratis, Toilet Bersih, Parkir Luas">
                </div>

                {{-- INPUT GALERI (Multiple) --}}
                <div>
                    <label class="block text-slate-400 text-sm font-medium mb-2">Galeri Foto Tambahan</label>
                    <input type="file" name="gallery[]" multiple
                        class="w-full file:bg-slate-700 file:text-white file:border-none file:py-2 file:px-4 file:rounded-xl file:mr-4
                      bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white">
                    <p class="text-xs text-slate-500 mt-1">Bisa pilih lebih dari satu foto.</p>
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