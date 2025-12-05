@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Dashboard Overview</h1>
            <p class="text-slate-400">Selamat datang kembali di panel admin eFutsal.</p>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Card 1: Total Pendapatan --}}
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-blue-500/10 transition-transform group-hover:scale-110">
            </div>
            <div class="relative">
                <p class="text-slate-400 text-sm font-medium">Total Pendapatan</p>
                {{-- Variabel: $totalRevenue (dari DashboardController) --}}
                <h3 class="text-3xl font-bold text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center text-xs text-blue-400">
                    <span class="bg-blue-500/10 px-2 py-1 rounded-lg">Paid & Confirmed</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Booking --}}
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-purple-500/10 transition-transform group-hover:scale-110">
            </div>
            <div class="relative">
                <p class="text-slate-400 text-sm font-medium">Total Reservasi</p>
                {{-- Variabel: $totalBookings --}}
                <h3 class="text-3xl font-bold text-white mt-1">{{ $totalBookings }}</h3>
                <div class="mt-4 flex items-center text-xs text-purple-400">
                    <span>Semua Transaksi</span>
                </div>
            </div>
        </div>

        {{-- Card 3: Booking Pending --}}
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-orange-500/10 transition-transform group-hover:scale-110">
            </div>
            <div class="relative">
                <p class="text-slate-400 text-sm font-medium">Menunggu Konfirmasi</p>
                {{-- Variabel: $pendingBookings --}}
                <h3 class="text-3xl font-bold text-white mt-1">{{ $pendingBookings }}</h3>
                <div class="mt-4 flex items-center text-xs text-orange-400">
                    <span class="bg-orange-500/10 px-2 py-1 rounded-lg">Perlu Tindakan</span>
                </div>
            </div>
        </div>

        {{-- Card 4: Lapangan Aktif --}}
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-emerald-500/10 transition-transform group-hover:scale-110">
            </div>
            <div class="relative">
                <p class="text-slate-400 text-sm font-medium">Lapangan Aktif</p>
                {{-- Mengambil jumlah lapangan langsung dari Model Field --}}
                <h3 class="text-3xl font-bold text-white mt-1">{{ \App\Models\Field::count() }}</h3>
                <div class="mt-4 flex items-center text-xs text-emerald-400">
                    <span>Total Fasilitas</span>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL BOOKING TERBARU --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg overflow-hidden">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Reservasi Terbaru</h3>
            {{-- Route: admin.reservations.index (sesuai web.php) --}}
            <a href="{{ route('admin.reservations.index') }}" class="text-sm text-blue-400 hover:text-blue-300">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-400">
                <thead class="bg-slate-700/50 text-slate-200 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Lapangan</th>
                        <th class="px-6 py-4">Tanggal & Jam</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($latestBookings as $booking)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-white">
                            {{-- Null Coalescing: Mencegah error jika user dihapus --}}
                            {{ $booking->user->name ?? 'Guest' }}
                        </td>
                        <td class="px-6 py-4">
                            {{-- Relasi ke Field --}}
                            {{ $booking->field->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                            <div class="text-xs text-slate-500">
                                {{-- Format Jam agar lebih rapi (H:i) --}}
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-white">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $statusClass = match($booking->status) {
                            'paid', 'confirmed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            'pending' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
                            'cancelled' => 'bg-red-500/10 text-red-400 border-red-500/20',
                            default => 'bg-slate-700 text-slate-400 border-slate-600'
                            };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data reservasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection