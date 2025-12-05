@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Edit Lapangan: {{ $field->name }}</h1>
            <a href="{{ route('admin.fields.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">
                &larr; Kembali ke Daftar Lapangan
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-6 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-8">

            {{-- CARD 1: DATA UTAMA & HARGA --}}
            <div class="bg-slate-800 p-8 rounded-2xl border border-slate-700 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Informasi Dasar & Tarif</h3>

                {{-- FORM UPDATE DATA UTAMA --}}
                <form action="{{ route('admin.fields.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        {{-- Nama Lapangan --}}
                        <div>
                            <label for="name" class="block text-slate-400 text-sm font-medium mb-2">Nama
                                Lapangan</label>
                            <input type="text" name="name" id="name"
                                class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors"
                                value="{{ old('name', $field->name) }}" required>
                            @error('name')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Kapasitas --}}
                            <div>
                                <label for="capacity" class="block text-slate-400 text-sm font-medium mb-2">Kapasitas
                                    (Orang)</label>
                                <input type="number" name="capacity" id="capacity"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors"
                                    value="{{ old('capacity', $field->capacity) }}" required min="1">
                                @error('capacity')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Biaya Per Jam --}}
                            <div>
                                <label for="hourly_rate" class="block text-slate-400 text-sm font-medium mb-2">Biaya Per Jam
                                    (Rp)</label>
                                <input type="number" name="hourly_rate" id="hourly_rate"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors"
                                    value="{{ old('hourly_rate', $field->hourly_rate) }}" required min="1000">
                                @error('hourly_rate')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Gambar Lapangan (Utama) --}}
                        <div>
                            <label for="image" class="block text-slate-400 text-sm font-medium mb-2">Gambar Utama
                                Lapangan</label>
                            @if ($field->image)
                                <div class="mb-3">
                                    <p class="text-xs text-slate-500 mb-2">Gambar Saat Ini:</p>
                                    <img src="{{ Str::startsWith($field->image, 'http') ? $field->image : asset('storage/' . $field->image) }}"
                                        alt="Current Image"
                                        class="h-20 w-auto rounded-lg border border-slate-700 object-cover">
                                </div>
                            @endif
                            <input type="file" name="image" id="image"
                                class="w-full file:bg-emerald-600 file:text-white file:border-none file:py-2 file:px-4 file:rounded-xl file:cursor-pointer file:hover:bg-emerald-500 file:transition file:mr-4
                                  bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500"
                                accept="image/*">
                            <p class="text-xs text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            @error('image')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tombol Update --}}
                    <div class="mt-8 flex items-center gap-4">
                        <button type="submit"
                            class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl transition-colors shadow-lg shadow-emerald-600/30">
                            Update Data Utama
                        </button>
                    </div>
                </form>
            </div>


            {{-- CARD 2: EDIT FASILITAS --}}
            {{-- Mengarah ke endpoint fields/{field}/facilities --}}
            <div class="bg-slate-800 p-8 rounded-2xl border border-slate-700 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Edit Fasilitas (Amenities)</h3>

                <form action="{{ route('admin.fields.facilities.update', $field->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="facilities" class="block text-slate-400 text-sm font-medium mb-2">Daftar Fasilitas
                            (Pisahkan dengan koma)</label>
                        <textarea name="facilities" id="facilities" rows="4"
                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition-colors">
@foreach ($field->facilities as $f)
{{ $f->name }}{{ $loop->last ? '' : ', ' }}
@endforeach
</textarea>
                        <p class="text-xs text-slate-500 mt-2">Contoh: Wifi Gratis, Kamar Mandi Bersih, Area Parkir</p>
                        @error('facilities')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/30">
                        Update Fasilitas
                    </button>
                </form>
            </div>


            {{-- CARD 3: EDIT GALERI FOTO --}}
            {{-- Mengarah ke endpoint fields/{field}/gallery --}}
            <div class="bg-slate-800 p-8 rounded-2xl border border-slate-700 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Kelola Galeri Foto Tambahan
                </h3>

                {{-- Form Tambah Galeri Baru (Upload Multi-file) --}}
                <form action="{{ route('admin.fields.gallery.update', $field->id) }}" method="POST"
                    enctype="multipart/form-data" class="mb-8 p-4 border border-slate-700 rounded-xl">
                    @csrf
                    @method('PATCH')
                    <h4 class="text-slate-300 font-medium mb-3">Tambah Foto Baru</h4>
                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <input type="file" name="gallery[]" multiple
                                class="w-full file:bg-emerald-600 file:text-white file:border-none file:py-2 file:px-4 file:rounded-xl file:cursor-pointer file:hover:bg-emerald-500 file:transition file:mr-4
                                  bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white"
                                accept="image/*" required>
                        </div>
                        <button type="submit"
                            class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl hover:bg-emerald-500 transition-colors">
                            Upload
                        </button>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Pilih beberapa foto sekaligus.</p>
                    @error('gallery.*')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </form>

                {{-- Daftar Foto Galeri Saat Ini --}}
                <h4 class="text-slate-300 font-medium mb-3">Foto Galeri Saat Ini ({{ $field->galleries->count() }})</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse ($field->galleries as $gallery)
                        <div class="relative group aspect-square rounded-xl overflow-hidden border border-slate-700">
                            <img src="{{ asset('storage/' . $gallery->image) }}"
                                class="w-full h-full object-cover transition group-hover:opacity-70">

                            {{-- Tombol Hapus (Mengarah ke route deleteGallery) --}}
                            <form action="{{ route('admin.fields.gallery.delete', $gallery->id) }}" method="POST"
                                onsubmit="return confirm('Hapus foto ini?');" class="absolute top-2 right-2 z-10">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 text-white p-1 rounded-full hover:bg-red-700 transition shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-slate-500 italic col-span-4">Belum ada foto galeri tambahan.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
