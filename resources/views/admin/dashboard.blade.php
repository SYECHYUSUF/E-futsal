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

            {{-- Card 1: Total Pendapatan (FIXED) --}}
            <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden group">
                <div
                    class="absolute right-0 top-0 h-32 w-32 translate-x-8 translate-y-[-50%] rounded-full bg-blue-500/10 transition-transform group-hover:scale-110">
                </div>
                <div class="relative">
                    <p class="text-slate-400 text-sm font-medium">Total Pendapatan</p>
                    {{-- MENGGUNAKAN VARIABEL DARI CONTROLLER --}}
                    <h3 class="text-3xl font-bold text-white mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
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
                    <h3 class="text-3xl font-bold text-white mt-1">{{ $totalBooking }}</h3>
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
                    <h3 class="text-3xl font-bold text-white mt-1">{{ $bookingPending }}</h3>
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
                    {{-- Query aman untuk count lapangan --}}
                    <h3 class="text-3xl font-bold text-white mt-1">{{ \App\Models\Lapangan::count() }}</h3>
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
                {{-- Tombol opsional jika ada route index reservasi --}}
                {{-- <a href="{{ route('admin.reservasi.index') }}" class="text-sm text-blue-400 hover:text-blue-300">Lihat Semua &rarr;</a> --}}
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
                                    {{ $booking->user->name ?? 'Guest' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $booking->lapangan->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div>{{ $booking->tanggal_booking }}</div>
                                    <div class="text-xs text-slate-500">{{ $booking->jam_mulai }} -
                                        {{ $booking->jam_selesai }}</div>
                                </td>
                                <td class="px-6 py-4 text-white">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($booking->status == 'paid' || $booking->status == 'confirmed')
                                        <span
                                            class="bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-full text-xs font-medium border border-emerald-500/20">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    @elseif($booking->status == 'pending')
                                        <span
                                            class="bg-orange-500/10 text-orange-400 px-3 py-1 rounded-full text-xs font-medium border border-orange-500/20">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    @else
                                        <span
                                            class="bg-slate-700 text-slate-400 px-3 py-1 rounded-full text-xs font-medium border border-slate-600">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    @endif
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
