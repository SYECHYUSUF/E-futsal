<footer class="bg-slate-900 border-t border-slate-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            
            <div class="space-y-4">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="font-bold text-xl text-white">e<span class="text-emerald-400">Futsal</span></span>
                </a>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Platform booking lapangan futsal #1 di Indonesia. Kami memudahkan tim Anda untuk menemukan dan memesan lapangan berkualitas dalam hitungan detik.
                </p>
                <div class="flex space-x-4 pt-2">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-emerald-600 transition-all duration-300">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-6 text-white">Menu Utama</h3>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-emerald-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('lapangan.index') }}" class="hover:text-emerald-400 transition-colors">Daftar Lapangan</a></li>
                    <li><a href="{{ route('reservasi.create') }}" class="hover:text-emerald-400 transition-colors">Booking Lapangan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-6 text-white">Bantuan</h3>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Cara Booking</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-emerald-400 transition-colors">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-6 text-white">Kontak</h3>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Jl. Sudirman No. 45, Jakarta Pusat, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>+62 812-3456-7890</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} eFutsal Inc. All rights reserved.
            </p>
            <div class="flex gap-6 text-sm text-slate-500">
                <a href="#" class="hover:text-emerald-400 transition-colors">Privacy</a>
                <a href="#" class="hover:text-emerald-400 transition-colors">Terms</a>
            </div>
        </div>
    </div>
</footer>