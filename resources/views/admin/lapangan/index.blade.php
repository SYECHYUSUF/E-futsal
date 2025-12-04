@extends('layouts.admin')

@section('content')
    {{-- Container utama disesuaikan untuk konsistensi dengan dashboard --}}
    <div class="p-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Manajemen Lapangan</h1>
                <p class="text-slate-400">Kelola daftar lapangan yang tersedia untuk reservasi.</p>
            </div>
            <a href="{{ route('admin.lapangan.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-colors">
                Tambah Lapangan
            </a>
        </div>

        {{-- Tabel Container diganti menjadi dark mode --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-400">
                    <thead class="bg-slate-700/50 text-slate-200 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Gambar</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Harga / Jam</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach ($lapangans as $l)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    @if ($l->gambar)
                                        {{-- Ukuran gambar disesuaikan --}}
                                        <img src="{{ asset('storage/' . $l->gambar) }}"
                                            class="w-16 h-16 object-cover rounded-md border border-slate-700">
                                    @else
                                        <span class="text-slate-500">No Img</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-white">{{ $l->nama }}</td>
                                <td class="px-6 py-4 text-white">Rp {{ number_format($l->biaya_per_jam, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 flex space-x-4">
                                    {{-- Warna link Edit diubah --}}
                                    <a href="{{ route('admin.lapangan.edit', $l->id) }}"
                                        class="text-blue-400 hover:text-blue-300 transition-colors">Edit</a>

                                    <form action="{{ route('admin.lapangan.destroy', $l->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus lapangan {{ $l->nama }}?');">
                                        @csrf @method('DELETE')
                                        {{-- Warna link Hapus diubah --}}
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-400 transition-colors">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
