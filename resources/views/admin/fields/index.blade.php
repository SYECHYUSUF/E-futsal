@extends('layouts.admin')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Lapangan</h1>
            <p class="text-slate-400">Kelola daftar lapangan yang tersedia untuk reservasi.</p>
        </div>
        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.fields.create') }}"
            class="bg-emerald-600 text-white px-4 py-2 rounded-xl shadow-lg hover:bg-emerald-500 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Lapangan
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
    <div class="mb-6 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- TABLE CONTAINER --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-400">
                <thead class="bg-slate-700/50 text-slate-200 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Nama Lapangan</th>
                        <th class="px-6 py-4">Kapasitas</th>
                        <th class="px-6 py-4">Harga / Jam</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    {{-- Menggunakan @forelse untuk handle jika data kosong --}}
                    @forelse ($fields as $field)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="h-16 w-24 rounded-lg overflow-hidden border border-slate-600 bg-slate-900">
                                @if ($field->image)
                                <img src="{{ asset('storage/' . $field->image) }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-slate-500">
                                    No Image
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-white text-base">{{ $field->name }}</div>
                            <div class="text-xs text-slate-500 mt-1">ID: #{{ $field->id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-700 text-slate-300 px-2 py-1 rounded text-xs">
                                {{ $field->capacity }} Orang
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-emerald-400">
                            Rp {{ number_format($field->hourly_rate, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Tombol Detail/Statistik (Fitur yang baru kita buat) --}}
                                <a href="{{ route('admin.fields.show', $field->id) }}"
                                    class="p-2 bg-slate-700 text-blue-400 rounded-lg hover:bg-slate-600 transition tooltip" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.fields.edit', $field->id) }}"
                                    class="p-2 bg-slate-700 text-amber-400 rounded-lg hover:bg-slate-600 transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan {{ $field->name }}? Data reservasi terkait mungkin ikut terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-slate-700 text-red-400 rounded-lg hover:bg-red-900/50 transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <p>Belum ada data lapangan.</p>
                                <a href="{{ route('admin.fields.create') }}" class="mt-2 text-emerald-400 hover:text-emerald-300 text-sm font-bold">Tambah Sekarang &rarr;</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection