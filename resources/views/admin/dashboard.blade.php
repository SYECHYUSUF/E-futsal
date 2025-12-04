<x-admin-layout>
    @section('header', 'Dashboard Statistik')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-emerald-500/10 transition-transform group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-slate-400 text-sm font-medium">Total Booking</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ \App\Models\Reservasi::count() }}</h3>
                <div class="mt-4 flex items-center text-xs text-emerald-400">
                    <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>Update Real-time</span>
                </div>
            </div>
        </div>

        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-blue-500/10 transition-transform group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-slate-400 text-sm font-medium">Total Pendapatan</p>
                <h3 class="text-3xl font-bold text-white mt-1">Rp {{ number_format(\App\Models\Reservasi::where('status', 'confirmed')->sum('total_harga'), 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center text-xs text-blue-400">
                    <span>Confirmed Only</span>
                </div>
            </div>
        </div>

        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-purple-500/10 transition-transform group-hover:scale-110"></div>
            <div class="relative">
                <p class="text-slate-400 text-sm font-medium">Lapangan Aktif</p>
                <h3 class="text-3xl font-bold text-white mt-1">{{ \App\Models\Lapangan::count() }}</h3>
                <div class="mt-4 flex items-center text-xs text-purple-400">
                    <span>Siap digunakan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Booking Terbaru</h3>
            <a href="{{ route('admin.reservasi.index') }}" class="text-sm text-emerald-400 hover:text-emerald-300">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-900/50 text-xs uppercase text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Lapangan</th>
                        <th class="px-6 py-4">Jadwal</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @foreach(\App\Models\Reservasi::with('user', 'lapangan')->latest()->take(5)->get() as $res)
                    <tr class="hover:bg-slate-700/50 transition">
                        <td class="px-6 py-4 text-white font-medium">{{ $res->user->name ?? 'Guest' }}</td>
                        <td class="px-6 py-4 text-slate-300">{{ $res->lapangan->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-300">
                            {{ \Carbon\Carbon::parse($res->tanggal_main)->format('d M') }}, {{ substr($res->jam_mulai, 0, 5) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold 
                                {{ $res->status == 'confirmed' ? 'bg-emerald-500/20 text-emerald-400' : 
                                  ($res->status == 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">
                                {{ ucfirst($res->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>