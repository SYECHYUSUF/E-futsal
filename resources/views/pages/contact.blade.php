<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - eFutsal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    <x-navbar />

    <main class="flex-grow pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-gray-900">Hubungi Kami</h1>
                <p class="mt-4 text-lg text-gray-600">Punya pertanyaan atau butuh bantuan? Tim kami siap membantu 24/7.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-white rounded-3xl shadow-xl overflow-hidden">

                <div class="bg-blue-600 p-10 text-white flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-blue-500 rounded-full opacity-50">
                    </div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 bg-blue-400 rounded-full opacity-30">
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-6">Informasi Kontak</h3>
                        <p class="text-blue-100 mb-8">
                            Isi formulir di samping dan tim kami akan merespons dalam waktu kurang dari 24 jam.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <span class="font-medium">+62 812 3456 7890</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="font-medium">support@efutsal.com</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Jakarta, Indonesia</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 mt-12">
                        <div class="flex gap-4">
                            <a href="#"
                                class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center hover:bg-white hover:text-blue-600 transition">F</a>
                            <a href="#"
                                class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center hover:bg-white hover:text-blue-600 transition">T</a>
                            <a href="#"
                                class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center hover:bg-white hover:text-blue-600 transition">I</a>
                        </div>
                    </div>
                </div>

                <div class="p-10 bg-white">
                    <form action="#" method="POST" class="space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Depan</label>
                                <input type="text"
                                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 transition"
                                    placeholder="John">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Belakang</label>
                                <input type="text"
                                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 transition"
                                    placeholder="Doe">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email"
                                class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 transition"
                                placeholder="john@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                            <textarea rows="4"
                                class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-blue-500 focus:bg-white focus:ring-0 transition"
                                placeholder="Apa yang bisa kami bantu?"></textarea>
                        </div>

                        <button type="button"
                            class="w-full bg-gray-900 text-white font-bold py-4 rounded-lg hover:bg-black transform hover:-translate-y-1 transition-all duration-200">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
