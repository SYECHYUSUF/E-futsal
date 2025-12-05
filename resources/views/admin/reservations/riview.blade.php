<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Reservasi #{{ $reservasi->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="border-b border-gray-100 pb-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Pesanan</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Pemesan:</span>
                            <span class="font-medium">{{ $reservasi->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Lapangan:</span>
                            <span class="font-medium">{{ $reservasi->lapangan->nama }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jadwal:</span>
                            <span class="font-medium">
                                {{ $reservasi->date->format('d M Y') }} 
                                ({{ $reservasi->start_time->format('H:i') }} - {{ $reservasi->end_time->format('H:i') }})
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Harga:</span>
                            <span class="font-bold text-blue-600">Rp {{ number_format($reservasi->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status Saat Ini:</span>
                            <span class="px-2 py-1 rounded-full text-xs font-bold 
                                {{ $reservasi->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                  ($reservasi->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($reservasi->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($reservasi->status == 'pending')
                    
                    @if($action == 'approve')
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                            <h4 class="text-green-800 font-bold text-lg mb-2">Konfirmasi Terima?</h4>
                            <p class="text-green-600 text-sm mb-6">Pastikan jadwal lapangan memang kosong.</p>
                            
                            <form action="{{ route('admin.reservasi.approve', $reservasi->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition shadow-lg shadow-green-600/30">
                                    ✅ YA, TERIMA SEKARANG
                                </button>
                            </form>
                            <a href="{{ route('admin.reservasi.index') }}" class="block mt-4 text-sm text-gray-500 underline">Batal & Kembali</a>
                        </div>

                    @elseif($action == 'reject')
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                            <h4 class="text-red-800 font-bold text-lg mb-4 text-center">Tolak Pesanan?</h4>
                            
                            <form action="{{ route('admin.reservasi.reject', $reservasi->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-red-700 mb-1">Alasan Penolakan (Wajib)</label>
                                    <textarea name="reason" rows="3" class="w-full border-red-300 rounded-md focus:ring-red-500 focus:border-red-500" placeholder="Misal: Maaf lapangan sedang renovasi..." required autofocus></textarea>
                                </div>
                                <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition shadow-lg shadow-red-600/30">
                                    ❌ TOLAK & KIRIM WA
                                </button>
                            </form>
                            <a href="{{ route('admin.reservasi.index') }}" class="block mt-4 text-sm text-center text-gray-500 underline">Batal & Kembali</a>
                        </div>

                    @else
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.reservasi.review', ['reservasi' => $reservasi->id, 'action' => 'approve']) }}" class="bg-green-100 text-green-700 font-bold py-3 rounded-lg text-center hover:bg-green-200">
                                Terima
                            </a>
                            <a href="{{ route('admin.reservasi.review', ['reservasi' => $reservasi->id, 'action' => 'reject']) }}" class="bg-red-100 text-red-700 font-bold py-3 rounded-lg text-center hover:bg-red-200">
                                Tolak
                            </a>
                        </div>
                    @endif

                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">Reservasi ini sudah diproses.</p>
                        <a href="{{ route('admin.reservasi.index') }}" class="text-blue-600 font-bold mt-2 inline-block">Kembali ke Dashboard</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>