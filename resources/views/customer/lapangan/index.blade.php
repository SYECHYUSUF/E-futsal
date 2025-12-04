<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <p class="text-gray-600">Temukan lapangan yang cocok untuk timmu.</p>
                </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($lapangans as $lapangan)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full hover:shadow-md transition-shadow duration-300">
                        <div class="relative h-48 bg-gray-200">
                            @if($lapangan->gambar)
                                <img src="{{ asset('storage/' . $lapangan->gambar) }}" alt="{{ $lapangan->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-0 right-0 m-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                Kapasitas {{ $lapangan->kapasitas }}
                            </div>
                        </div>

                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $lapangan->nama }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $lapangan->deskripsi ?? 'Lapangan futsal berkualitas dengan fasilitas lengkap.' }}
                                </p>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-500 block">Harga Sewa</span>
                                    <span class="text-lg font-bold text-blue-600">Rp {{ number_format($lapangan->biaya_per_jam, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-500">/ jam</span>
                                </div>
                                
                                <a href="{{ route('reservasi.create', ['lapangan_id' => $lapangan->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Booking
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        Belum ada data lapangan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>