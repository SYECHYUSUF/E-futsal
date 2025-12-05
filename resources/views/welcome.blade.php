<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'eFutsal') }} - Booking Lapangan Futsal Modern</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hero-pattern {
            background-color: #0f172a;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231e293b' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .text-glow {
            text-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
        }
    </style>
</head>

<body class="antialiased bg-slate-900 text-white selection:bg-emerald-500 selection:text-white">

    <x-navbar />

    <section id="home" class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://cdn.grid.id/crop/0x0:0x0/x/photo/2024/11/15/lapangan-sepak-bolajpg-20241115074613.jpg "
                alt="Futsal Field"
                class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 mb-8 backdrop-blur-sm animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-sm font-medium text-emerald-300">Sistem Booking Online #1</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                Main Futsal? <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400 text-glow">Booking Aja Di Sini!</span>
            </h1>

            <p class="mt-4 text-xl text-slate-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                Temukan lapangan terbaik, cek jadwal real-time, dan booking dalam hitungan detik. Tanpa antri, tanpa ribet.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('customer.fields.index') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-emerald-600 rounded-2xl hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-600/40 hover:shadow-emerald-600/60 transform hover:-translate-y-1">
                    Cari Lapangan
                </a>
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-slate-300 bg-slate-800/50 border border-slate-700 rounded-2xl hover:bg-slate-800 hover:text-white transition-all backdrop-blur-sm">
                    Buat Akun Baru
                </a>
            </div>

            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-slate-800 pt-10">
                <div>
                    <div class="text-3xl font-bold text-white">24/7</div>
                    <div class="text-sm text-slate-400 mt-1">Layanan Buka</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">3+</div>
                    <div class="text-sm text-slate-400 mt-1">Jenis Lapangan</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">100%</div>
                    <div class="text-sm text-slate-400 mt-1">Pembayaran Aman</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">Fast</div>
                    <div class="text-sm text-slate-400 mt-1">Proses Booking</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Pilihan <span class="text-emerald-400">Lapangan Terbaik</span></h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Pilih jenis lantai yang sesuai dengan gaya permainan tim kamu. Kualitas standar internasional.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group relative bg-slate-800 rounded-3xl overflow-hidden border border-slate-700 hover:border-emerald-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-900/20">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://centroflor.id/wp-content/uploads/elementor/thumbs/Lapangan-dengan-Karpet-Badminton-Biru-q4gr7f6l5wmnkdww4oaoanbaw805fkwle81xchf53c.jpg" alt="Vinyl" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2">Lapangan Vinyl</h3>
                        <p class="text-slate-400 text-sm mb-4">Lantai karet sintetis yang empuk, cocok untuk permainan cepat.</p>
                    </div>
                </div>
                <div class="group relative bg-slate-800 rounded-3xl overflow-hidden border border-slate-700 hover:border-emerald-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-900/20">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=2070&auto=format&fit=crop" alt="Sintetis" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2">Rumput Sintetis</h3>
                        <p class="text-slate-400 text-sm mb-4">Sensasi bermain seperti di lapangan besar. Grip maksimal.</p>
                    </div>
                </div>
                <div class="group relative bg-slate-800 rounded-3xl overflow-hidden border border-slate-700 hover:border-emerald-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-900/20">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?q=80&w=2070&auto=format&fit=crop" alt="Semen" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2">Lapangan Semen</h3>
                        <p class="text-slate-400 text-sm mb-4">Gaya klasik street futsal. Sirkulasi udara segar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-footer />

</body>

</html>