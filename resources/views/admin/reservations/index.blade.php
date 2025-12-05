@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Daftar Reservasi Masuk</h1>
            <p class="text-slate-400">Kelola konfirmasi, terima, atau tolak reservasi pelanggan.</p>
        </div>
    </div>

    @if (session('success'))
    <div class="mb-4 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-700 text-left text-sm text-slate-400">
                <thead class="bg-slate-700/50 text-slate-200 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Pemesan</th>
                        <th class="px-6 py-4">Lapangan</th>
                        <th class="px-6 py-4">Jadwal</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse ($reservations as $reservation)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-white">#{{ $reservation->id }}</td>
                        <td class="px-6 py-4">
                            <div class="text-white font-medium">{{ $reservation->user->name ?? 'User Hilang' }}</div>
                            <div class="text-xs text-slate-500">{{ $reservation->user->phone ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-300">{{ $reservation->field->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ \Carbon\Carbon::parse($reservation->booking_date)->format('d M Y') }}</div>
                            <div class="text-xs text-slate-500">{{ $reservation->start_time }} - {{ $reservation->end_time }}</div>
                        </td>
                        <td class="px-6 py-4 text-white">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full border 
                                @if ($reservation->status == 'confirmed' || $reservation->status == 'paid') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                @elseif($reservation->status == 'pending') bg-orange-500/10 text-orange-400 border-orange-500/20
                                @elseif($reservation->status == 'cancelled') bg-red-500/10 text-red-400 border-red-500/20
                                @else bg-slate-700 text-slate-400 border-slate-600 @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.reservations.show', $reservation->id) }}"
                                class="text-blue-400 hover:text-blue-300 font-bold transition-colors bg-blue-500/10 px-4 py-2 rounded-lg border border-blue-500/20 hover:bg-blue-500/20">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">Belum ada data reservasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection