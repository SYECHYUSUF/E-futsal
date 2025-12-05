<nav x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'bg-slate-900/95 backdrop-blur-md shadow-lg border-b border-slate-800' : 'bg-transparent'"
    class="fixed w-full z-50 transition-all duration-300 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <div class="flex-shrink-0 flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-all">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-white">e<span class="text-emerald-400">Futsal</span></span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-emerald-400' : 'text-slate-300 hover:text-white' }} transition-colors">Beranda</a>
                <a href="{{ route('about') }}" class="text-sm font-medium {{ request()->routeIs('about') ? 'text-emerald-400' : 'text-slate-300 hover:text-white' }} transition-colors">Tentang Kami</a>
                <a href="{{ route('customer.fields.index') }}" class="text-sm font-medium {{ request()->routeIs('customer.fields.index') ? 'text-emerald-400' : 'text-slate-300 hover:text-white' }} transition-colors">Lapangan</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium {{ request()->routeIs('contact') ? 'text-emerald-400' : 'text-slate-300 hover:text-white' }} transition-colors">Kontak</a>

                <div class="flex items-center gap-4 ml-4">
                    @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 text-sm font-semibold text-white bg-emerald-600 rounded-full hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/50 transform hover:-translate-y-0.5">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-emerald-400 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-semibold text-slate-900 bg-white rounded-full hover:bg-emerald-50 transition-all shadow-lg shadow-white/10 transform hover:-translate-y-0.5">
                        Daftar
                    </a>
                    @endauth
                </div>
            </div>

            <div class="md:hidden flex items-center">
                <button @click="open = ! open" class="text-slate-300 hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-slate-900 border-t border-slate-800 shadow-xl absolute w-full">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-emerald-400 bg-slate-800' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">Beranda</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'text-emerald-400 bg-slate-800' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">Tentang Kami</a>
            <a href="{{ route('customer.fields.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('customer.fields.index') ? 'text-emerald-400 bg-slate-800' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">Lapangan</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'text-emerald-400 bg-slate-800' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">Kontak</a>
            <a href="{{ route('reservations.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-emerald-400 hover:text-emerald-300">Booking Sekarang</a>
        </div>
        <div class="pt-4 pb-4 border-t border-slate-800 px-4">
            @auth
            <a href="{{ route('dashboard') }}" class="block w-full text-center py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-500">Dashboard</a>
            @else
            <div class="flex gap-2">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2 border border-slate-600 rounded-lg font-medium text-slate-300 hover:text-white hover:border-slate-500">Masuk</a>
                <a href="{{ route('register') }}" class="flex-1 text-center py-2 bg-white text-slate-900 rounded-lg font-bold hover:bg-emerald-50">Daftar</a>
            </div>
            @endauth
        </div>
    </div>
</nav>