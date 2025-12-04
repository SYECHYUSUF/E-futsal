@extends('layouts.admin')

@section('content')
    <div class="p-6">
        {{-- HEADER --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Daftar Reservasi Masuk</h1>
                <p class="text-slate-400">Kelola konfirmasi, terima, atau tolak reservasi pelanggan.</p>
            </div>
        </div>

        {{-- ALERT MESSAGES --}}
        @if (session('success'))
            <div class="mb-4 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-lg relative"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-800/50 border border-red-700 text-red-400 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- TABLE CONTAINER --}}
        {{-- Menggunakan palet bg-slate-800 dan border-slate-700 --}}
        <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg overflow-hidden" x-data="{ showRejectModal: false, selectedId: null }">
            <div class="overflow-x-auto">
                {{-- Table disesuaikan untuk dark mode --}}
                <table class="min-w-full divide-y divide-slate-700 text-left text-sm text-slate-400">
                    <thead class="bg-slate-700/50 text-slate-200 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Pemesan</th>
                            <th class="px-6 py-4">Lapangan</th>
                            <th class="px-6 py-4">Jadwal</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse ($reservations as $res)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-white">#{{ $res->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-white">{{ $res->user->name ?? 'User Hilang' }}
                                    </div>
                                    <div class="text-xs text-slate-500">{{ $res->user->phone ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-400">{{ $res->lapangan->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-white">{{ $res->date->format('d M Y') }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ $res->start_time->format('H:i') }} - {{ $res->end_time->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white">Rp
                                    {{ number_format($res->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- Status Badges Disesuaikan --}}
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full border 
                                        @if ($res->status == 'confirmed') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @elseif($res->status == 'pending') bg-orange-500/10 text-orange-400 border-orange-500/20
                                        @elseif($res->status == 'cancelled') bg-red-500/10 text-red-400 border-red-500/20
                                        @else bg-slate-700 text-slate-400 border-slate-600 @endif">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($res->status == 'pending')
                                        <form action="{{ route('admin.reservasi.approve', $res->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            {{-- Tombol Accept disesuaikan --}}
                                            <button type="submit" onclick="return confirm('Yakin terima jadwal ini?')"
                                                class="text-emerald-400 hover:text-emerald-300 mr-3 transition-colors">Terima</button>
                                        </form>

                                        {{-- Tombol Reject disesuaikan --}}
                                        <button @click="showRejectModal = true; selectedId = {{ $res->id }}"
                                            class="text-red-400 hover:text-red-300 transition-colors">
                                            Tolak
                                        </button>
                                    @else
                                        <span class="text-slate-500">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500">Belum ada data reservasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- REJECT MODAL --}}
        <div x-show="showRejectModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showRejectModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/75 transition-opacity"
                    {{-- Backdrop gelap --}} @click="showRejectModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showRejectModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">
                    {{-- Modal body gelap --}}

                    <form method="POST" :action="`{{ url('/admin/reservasi') }}/${selectedId}/reject`">
                        @csrf
                        <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Tolak Reservasi</h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-400 mb-4">
                                    Silakan masukkan alasan penolakan untuk memberitahu customer.
                                </p>
                                <textarea name="reason" rows="3"
                                    class="w-full border-slate-700 bg-slate-900 text-white rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                    placeholder="Contoh: Maaf, lapangan sedang maintenance mendadak." required></textarea>
                            </div>
                        </div>
                        <div class="bg-slate-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Tolak Sekarang
                            </button>
                            <button type="button" @click="showRejectModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-slate-700 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-slate-300 hover:bg-slate-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
