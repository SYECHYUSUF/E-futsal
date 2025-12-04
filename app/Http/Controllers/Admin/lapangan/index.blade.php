<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Lapangan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 text-right">
                <a href="{{ route('admin.lapangan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Tambah Lapangan</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Gambar</th>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Harga / Jam</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($lapangans as $l)
                        <tr>
                            <td class="px-6 py-4">
                                @if($l->gambar)
                                    <img src="{{ asset('storage/' . $l->gambar) }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No Img</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $l->nama }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($l->biaya_per_jam, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('admin.lapangan.edit', $l->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('admin.lapangan.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Hapus lapangan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>