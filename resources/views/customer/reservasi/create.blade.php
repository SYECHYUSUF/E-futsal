<x-app-layout>
    <div class="py-12" x-data="bookingSystem()">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('lapangan.index') }}"
                    class="text-slate-400 hover:text-emerald-400 flex items-center gap-2 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Lapangan
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">

                <div class="lg:col-span-1">
                    <div
                        class="bg-slate-800 rounded-3xl overflow-hidden shadow-xl border border-slate-700 sticky top-24">
                        <div class="h-48 overflow-hidden relative">
                            @if (isset($selectedLapangan) && $selectedLapangan->gambar)
                                <img src="{{ asset('storage/' . $selectedLapangan->gambar) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1575361204480-aadea25d4e68?auto=format&fit=crop&q=80"
                                    class="w-full h-full object-cover">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <h3 class="text-xl font-bold text-white">
                                    {{ $selectedLapangan->nama ?? 'Pilih Lapangan' }}</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center border-b border-slate-700 pb-4">
                                <span class="text-slate-400">Harga per Jam</span>
                                <span class="text-emerald-400 font-bold text-lg"
                                    x-text="formatRupiah(hargaPerJam)"></span>
                            </div>

                            <div class="bg-slate-900/50 p-4 rounded-xl space-y-2 border border-slate-700/50">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Jam Mulai</span>
                                    <span class="text-white font-bold"
                                        x-text="startTime ? startTime + ':00' : '-'"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-400">Durasi</span>
                                    <span class="text-white font-bold"><span x-text="duration"></span> Jam</span>
                                </div>
                                <div class="pt-2 border-t border-slate-700 mt-2 flex justify-between items-center">
                                    <span class="text-slate-400 font-bold">Total</span>
                                    <span class="text-emerald-400 font-extrabold text-xl"
                                        x-text="formatRupiah(totalPrice)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-slate-800 rounded-3xl p-8 shadow-xl border border-slate-700">
                        <h2 class="text-2xl font-bold text-white mb-6">Pilih Jadwal Main</h2>

                        <form action="{{ route('reservasi.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <input type="hidden" name="lapangan_id" x-model="lapanganId">
                            <input type="hidden" name="jam_mulai" x-model="formattedStartTime">
                            <input type="hidden" name="durasi" x-model="duration">
                            <input type="hidden" name="total_harga" x-model="totalPrice">

                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-2">Lapangan</label>
                                <select x-model="lapanganId" x-ref="lapanganSelect" @change="updateFieldDetails()"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="" disabled>-- Pilih Lapangan --</option>
                                    @foreach ($lapangans as $lapangan)
                                        <option value="{{ $lapangan->id }}" data-harga="{{ $lapangan->harga_per_jam }}">
                                            {{ $lapangan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-2">Tanggal Main</label>
                                <input type="date" x-model="date" @change="fetchBookedSlots()"
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-emerald-500 focus:border-emerald-500 color-scheme-dark"
                                    required>
                            </div>

                            <div x-show="lapanganId && date" x-transition class="mt-6">
                                <label class="block text-sm font-medium text-slate-400 mb-3">Pilih Jam (Klik untuk
                                    memilih durasi)</label>

                                <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-3">
                                    <template x-for="hour in availableHours" :key="hour">
                                        <button type="button" @click="toggleSlot(hour)" :disabled="isBooked(hour)"
                                            :class="{
                                                'bg-slate-900 border-slate-700 text-slate-300 hover:border-emerald-500':
                                                    !isSelected(hour) && !isBooked(hour),
                                                'bg-emerald-600 border-emerald-500 text-white shadow-lg shadow-emerald-600/40 ring-2 ring-emerald-400 ring-offset-2 ring-offset-slate-800': isSelected(
                                                    hour),
                                                'bg-red-900/20 border-red-900/30 text-red-700 cursor-not-allowed opacity-60': isBooked(
                                                    hour)
                                            }"
                                            class="py-3 rounded-xl text-sm font-bold border transition-all duration-200 flex flex-col items-center justify-center relative overflow-hidden group">

                                            <span x-text="formatTime(hour)"></span>

                                            <span class="text-[10px] font-normal mt-1"
                                                x-text="isBooked(hour) ? 'Booked' : (isSelected(hour) ? 'Dipilih' : 'Tersedia')">
                                            </span>

                                            <div x-show="isBooked(hour)"
                                                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjNDUwYTBhIi8+CjxwYXRoIGQ9Ik0wIDhMOCAwTTEgOUw5IDFNLTEgMUwxIC0xIiBzdHJva2U9IiM3ZjFkMWQiIHN0cm9rZS13aWR0aD0iMSIvPgo8L3N2Zz4=')] opacity-30">
                                            </div>
                                        </button>
                                    </template>
                                </div>
                                <p class="text-xs text-slate-500 mt-3">*Pilih beberapa jam berurutan untuk durasi lebih
                                    lama.</p>
                            </div>

                            <button type="submit" :disabled="duration === 0"
                                :class="duration > 0 ?
                                    'bg-emerald-600 hover:bg-emerald-500 shadow-emerald-600/20 hover:-translate-y-0.5' :
                                    'bg-slate-700 cursor-not-allowed text-slate-500'"
                                class="w-full py-4 text-white font-bold rounded-xl shadow-lg transition transform mt-6">
                                Konfirmasi Booking (<span x-text="duration"></span> Jam)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bookingSystem() {
            return {
                lapanganId: '{{ $selectedLapangan->id ?? '' }}',
                // Pastikan harga awal terisi jika ada lapangan terpilih, jika tidak 0
                hargaPerJam: {{ $selectedLapangan->harga_per_jam ?? 0 }},
                date: '',
                bookedSlots: [],
                selectedSlots: [],
                availableHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],

                init() {
                    // Set tanggal hari ini sebagai default
                    const today = new Date();
                    const year = today.getFullYear();
                    const month = String(today.getMonth() + 1).padStart(2, '0');
                    const day = String(today.getDate()).padStart(2, '0');
                    this.date = `${year}-${month}-${day}`;

                    // Jika sudah ada lapangan terpilih (dari halaman sebelumnya), ambil datanya
                    if (this.lapanganId) {
                        this.fetchBookedSlots();
                    }
                },

                // Fungsi baru: Update harga saat dropdown berubah
                updateFieldDetails() {
                    // Ambil elemen select menggunakan x-ref
                    const select = this.$refs.lapanganSelect;
                    const selectedOption = select.options[select.selectedIndex];

                    // Ambil harga dari data-harga, ubah ke integer. Default 0 jika gagal.
                    this.hargaPerJam = parseInt(selectedOption.dataset.harga) || 0;

                    // Reset pilihan jam karena ganti lapangan
                    this.resetSelection();

                    // Ambil ulang data booking
                    this.fetchBookedSlots();
                },

                fetchBookedSlots() {
                    if (!this.lapanganId || !this.date) return;

                    this.resetSelection();

                    // Fetch API untuk cek jadwal penuh
                    fetch(`{{ route('reservasi.check') }}?lapangan_id=${this.lapanganId}&tanggal=${this.date}`)
                        .then(response => response.json())
                        .then(data => {
                            this.bookedSlots = data;
                        })
                        .catch(error => console.error('Error:', error));
                },

                isBooked(hour) {
                    return this.bookedSlots.includes(hour);
                },

                isSelected(hour) {
                    return this.selectedSlots.includes(hour);
                },

                toggleSlot(hour) {
                    if (this.isBooked(hour)) return;

                    if (this.isSelected(hour)) {
                        // Jika diklik lagi, hapus dari pilihan
                        this.selectedSlots = this.selectedSlots.filter(h => h !== hour);
                    } else {
                        // Logika memilih jam berurutan
                        if (this.selectedSlots.length > 0) {
                            const min = Math.min(...this.selectedSlots);
                            const max = Math.max(...this.selectedSlots);

                            // Hanya boleh pilih jam persis sebelum atau sesudahnya
                            if (hour === min - 1 || hour === max + 1) {
                                this.selectedSlots.push(hour);
                            } else {
                                // Jika lompat jauh, reset dan mulai baru
                                this.selectedSlots = [hour];
                            }
                        } else {
                            this.selectedSlots.push(hour);
                        }
                    }
                    // Urutkan jam biar rapi
                    this.selectedSlots.sort((a, b) => a - b);
                },

                resetSelection() {
                    this.selectedSlots = [];
                },

                get startTime() {
                    return this.selectedSlots.length > 0 ? Math.min(...this.selectedSlots) : null;
                },

                get formattedStartTime() {
                    if (!this.startTime) return '';
                    return this.startTime.toString().padStart(2, '0') + ':00';
                },

                get duration() {
                    return this.selectedSlots.length;
                },

                get totalPrice() {
                    // Pastikan keduanya angka
                    return this.duration * parseInt(this.hargaPerJam);
                },

                formatTime(hour) {
                    return hour.toString().padStart(2, '0') + ':00';
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                }
            }
        }
    </script>
</x-app-layout>
