<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubungi Kami - {{ config('app.name', 'eFutsal') }}</title>

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
        <div class="space-y-12 pb-20 pt-10">

            {{-- 1. HERO HEADER --}}
            <div class="relative py-12 text-center overflow-hidden">
                {{-- Background Glow --}}
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-emerald-500/20 blur-[80px] rounded-full -z-10 pointer-events-none"></div>
                
                <span class="text-emerald-400 font-bold tracking-wider uppercase text-sm mb-3 block">Customer Service</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
                    Butuh <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">Bantuan?</span>
                </h1>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                    Tim kami siap membantu menjawab pertanyaan seputar booking, jadwal, atau fasilitas lapangan.
                </p>
            </div>
        
            <div class="container mx-auto px-4">
                <div class="grid lg:grid-cols-3 gap-8">
                    
                    {{-- 2. CONTACT INFO (Kiri) --}}
                    <div class="space-y-6">
                        
                        {{-- Card: Lokasi --}}
                        <div class="bg-slate-800/50 border border-slate-700 p-6 rounded-2xl flex items-start gap-4 hover:border-emerald-500/50 transition duration-300 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-emerald-500 border border-slate-700 group-hover:bg-emerald-500 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg mb-1">Lokasi Arena</h3>
                                <p class="text-slate-400 text-sm leading-relaxed">
                                    Jl. Perintis Kemerdekaan Km. 10,<br>
                                    Makassar, Sulawesi Selatan
                                </p>
                            </div>
                        </div>
        
                        {{-- Card: WhatsApp --}}
                        <div class="bg-slate-800/50 border border-slate-700 p-6 rounded-2xl flex items-start gap-4 hover:border-emerald-500/50 transition duration-300 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-emerald-500 border border-slate-700 group-hover:bg-emerald-500 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg mb-1">WhatsApp / Telepon</h3>
                                <p class="text-slate-400 text-sm mb-2">Fast response 08:00 - 22:00</p>
                                <a href="https://wa.me/6281234567890" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-semibold text-sm flex items-center gap-1">
                                    +62 812-3456-7890
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
        
                        {{-- Card: Email --}}
                        <div class="bg-slate-800/50 border border-slate-700 p-6 rounded-2xl flex items-start gap-4 hover:border-emerald-500/50 transition duration-300 group">
                            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-emerald-500 border border-slate-700 group-hover:bg-emerald-500 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-lg mb-1">Email Support</h3>
                                <p class="text-slate-400 text-sm mb-2">Untuk kerjasama & komplain</p>
                                <a href="mailto:support@efutsal.id" class="text-emerald-400 hover:text-emerald-300 font-semibold text-sm">
                                    support@efutsal.id
                                </a>
                            </div>
                        </div>
        
                    </div>
        
                    {{-- 3. CONTACT FORM (Kanan) --}}
                    <div class="lg:col-span-2 bg-slate-800 rounded-3xl border border-slate-700 p-8 relative overflow-hidden">
                        {{-- Decorative Circle --}}
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
                        <h3 class="text-2xl font-bold text-white mb-6 relative z-10">Kirim Pesan Langsung</h3>
                        
                        <form action="#" class="space-y-6 relative z-10">
                            <div class="grid md:grid-cols-2 gap-6">
                                {{-- Nama --}}
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-400">Nama Lengkap</label>
                                    <input type="text" placeholder="Masukkan namamu" 
                                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors placeholder:text-slate-600">
                                </div>
                                {{-- Email --}}
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-slate-400">Alamat Email</label>
                                    <input type="email" placeholder="email@contoh.com" 
                                        class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors placeholder:text-slate-600">
                                </div>
                            </div>
        
                            {{-- Subject --}}
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-slate-400">Subjek</label>
                                <select class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors cursor-pointer">
                                    <option>Pertanyaan Umum</option>
                                    <option>Kendala Booking</option>
                                    <option>Kerjasama / Sponsor</option>
                                </select>
                            </div>
        
                            {{-- Pesan --}}
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-slate-400">Pesan Kamu</label>
                                <textarea rows="4" placeholder="Tuliskan detail pertanyaan atau masukanmu di sini..." 
                                    class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-emerald-500 transition-colors placeholder:text-slate-600 resize-none"></textarea>
                            </div>
        
                            {{-- Tombol Kirim --}}
                            <button type="button" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-emerald-600/20 transform hover:-translate-y-0.5">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
        
                </div>
            </div>
        
            {{-- 4. MAPS SECTION --}}
            <div class="container mx-auto px-4 mt-12">
                <div class="bg-slate-800 p-2 rounded-2xl border border-slate-700">
                    <div class="w-full h-80 rounded-xl overflow-hidden grayscale hover:grayscale-0 transition duration-700">
                        {{-- Placeholder Google Maps --}}
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.578641951989!2d119.49397621476563!3d-5.171343096248604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbee275727e0295%3A0x6b677a29e4d10123!2sUniversitas%20Hasanuddin!5e0!3m2!1sid!2sid!4v1677649821234!5m2!1sid!2sid" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        
        </div>
    </main>

    {{-- FOOTER COMPONENT --}}
    <x-footer />

</body>
</html>