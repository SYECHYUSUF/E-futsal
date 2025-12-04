<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 px-4 sm:px-0">
                <div>
                    <h2 class="text-3xl font-bold text-white">Daftar Lapangan</h2>
                    <p class="text-slate-400 mt-1">Pilih lapangan terbaik untuk tim kamu</p>
                </div>
                </div>

            @if($lapangans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4 sm:px-0">
                    @foreach ($lapangans as $lapangan)
                        <div class="group bg-slate-800 rounded-3xl overflow-hidden border border-slate-700 shadow-xl hover:shadow-2xl hover:shadow-emerald-500/10 hover:border-emerald-500/50 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative h-56 overflow-hidden">
                                <div class="absolute inset-0 bg-slate-900 animate-pulse"></div> @if($lapangan->gambar)
                                    <img src="{{ asset('storage/' . $lapangan->gambar) }}" alt="{{ $lapangan->nama }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <img src="https://images.unsplash.com/photo-1575361204480-aadea25d4e68?auto=format&fit=crop&q=80" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @endif
                                
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-slate-900/80 backdrop-blur text-white text-xs font-bold uppercase tracking-wider rounded-full border border-slate-600">
                                        {{ $lapangan->jenis }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-emerald-400 transition-colors">{{ $lapangan->nama }}</h3>
                                <p class="text-slate-400 text-sm line-clamp-2 mb-4">{{ $lapangan->deskripsi }}</p>
                                
                                <div class="flex flex-col gap-4 mt-auto">
                                    <div class="flex items-center justify-between p-3 bg-slate-900/50 rounded-xl border border-slate-700/50">
                                        <div class="text-xs text-slate-500 uppercase font-bold">Harga Sewa</div>
                                        <div class="text-emerald-400 font-bold text-lg">
                                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}<span class="text-sm text-slate-500 font-normal">/jam</span>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('reservasi.create', ['lapangan_id' => $lapangan->id]) }}" class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-center transition shadow-lg shadow-emerald-600/20">
                                        Booking Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Belum ada lapangan</h3>
                    <p class="text-slate-500">Silakan kembali lagi nanti.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>