<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - {{ config('app.name', 'eFutsal') }}</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-900 text-slate-100 antialiased flex flex-col min-h-screen">

    {{-- NAVBAR COMPONENT --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        <div class="space-y-20 pb-20 pt-10">

            {{-- 1. HERO SECTION: Title & Vision --}}
            <div class="relative py-16 sm:py-24 overflow-hidden">
                {{-- Background Accents --}}
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[400px] bg-emerald-500/20 blur-[100px] rounded-full -z-10 pointer-events-none"></div>
        
                <div class="container mx-auto px-4 text-center">
                    <span class="text-emerald-400 font-bold tracking-wider uppercase text-sm mb-4 block">Tentang Kami</span>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                        Revolusi Booking Futsal <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">
                            Cepat, Mudah, & Modern
                        </span>
                    </h1>
                    <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                        Kami hadir untuk memudahkan pecinta futsal mendapatkan lapangan terbaik tanpa ribet.
                        Cek jadwal real-time, booking instan, dan mainkan pertandingan terbaikmu.
                    </p>
                </div>
            </div>
        
            {{-- 2. STATS SECTION (Trust Signals) --}}
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-slate-800/50 border border-slate-700 rounded-3xl p-8 backdrop-blur-sm">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">3+</div>
                        <div class="text-slate-500 text-sm font-medium">Lapangan Premium</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">24/7</div>
                        <div class="text-slate-500 text-sm font-medium">Akses Online</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">100%</div>
                        <div class="text-slate-500 text-sm font-medium">Jadwal Akurat</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">User</div>
                        <div class="text-slate-500 text-sm font-medium">Friendly Interface</div>
                    </div>
                </div>
            </div>
        
            {{-- 3. STORY & MISSION --}}
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    {{-- Kolom Kiri: Visual --}}
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative bg-slate-800 border border-slate-700 rounded-2xl p-8 h-full flex flex-col justify-center items-center text-center space-y-6">
                            <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Visi Kami</h3>
                            <p class="text-slate-400 leading-relaxed">
                                "Menjadi platform olahraga digital nomor satu yang menghubungkan komunitas, 
                                mempermudah akses fasilitas olahraga, dan mendorong gaya hidup sehat melalui teknologi."
                            </p>
                        </div>
                    </div>
        
                    {{-- Kolom Kanan: Penjelasan --}}
                    <div class="space-y-6">
                        <h2 class="text-3xl font-bold text-white">Mengapa Kami Berbeda?</h2>
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center border border-slate-700 text-emerald-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-lg">Real-Time Booking</h4>
                                    <p class="text-slate-400 text-sm mt-1">Tidak perlu telepon atau chat lama. Lihat slot kosong dan booking detik itu juga.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center border border-slate-700 text-emerald-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-lg">Konfirmasi Cepat</h4>
                                    <p class="text-slate-400 text-sm mt-1">Sistem validasi yang efisien memastikan jadwal mainmu aman dan terdata.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center border border-slate-700 text-emerald-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-lg">Harga Transparan</h4>
                                    <p class="text-slate-400 text-sm mt-1">Tidak ada biaya tersembunyi. Apa yang kamu lihat adalah apa yang kamu bayar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            {{-- 4. CTA --}}
            <div class="container mx-auto px-4">
                <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-8 md:p-16 text-center relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        
                    <div class="relative z-10">
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Mencetak Gol?</h2>
                        <p class="text-emerald-100 text-lg mb-8 max-w-xl mx-auto">
                            Jangan sampai kehabisan slot favoritmu. Booking lapangan sekarang dan rasakan keseruannya!
                        </p>
                        <a href="{{ route('customer.fields.index') }}" 
                           class="inline-block bg-white text-emerald-600 font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-slate-100 hover:scale-105 transition transform duration-300">
                            Cari Lapangan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        
        </div>
    </main>

    {{-- FOOTER COMPONENT --}}
    <x-footer />

</body>
</html>