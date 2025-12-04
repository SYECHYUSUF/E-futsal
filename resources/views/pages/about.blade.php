<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - eFutsal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    <x-navbar />

    <main class="flex-grow pt-20">
        <div class="bg-blue-600 py-20 text-center text-white relative overflow-hidden">
            <div
                class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
            </div>
            <div class="relative max-w-7xl mx-auto px-4">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">Tentang eFutsal</h1>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">
                    Mengenal lebih dekat siapa kami dan misi kami untuk merevolusi olahraga futsal di Indonesia.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-200 rounded-3xl transform -rotate-3 scale-105 opacity-50">
                    </div>
                    <img class="relative rounded-3xl shadow-2xl w-full object-cover h-96"
                        src="https://images.unsplash.com/photo-1574629810360-7efbbe4384d4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80"
                        alt="Tim Futsal">
                </div>

                <div class="mt-10 lg:mt-0">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Cerita Kami</h2>
                    <div class="prose text-gray-600 space-y-4 text-lg leading-relaxed">
                        <p>
                            Berawal dari kesulitan kami sendiri mencari lapangan futsal yang kosong di jam pulang kerja,
                            eFutsal lahir pada tahun 2024. Kami menyadari bahwa sistem booking manual lewat telepon
                            sudah tidak relevan lagi.
                        </p>
                        <p>
                            Visi kami sederhana: <strong>Membuat olahraga mudah diakses oleh semua orang.</strong>
                            Kami menghubungkan pemilik lapangan dengan pemain melalui teknologi yang mulus, transparan,
                            dan cepat.
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-6 mt-10 border-t border-gray-200 pt-8">
                        <div>
                            <span class="block text-3xl font-bold text-blue-600">50+</span>
                            <span class="text-sm text-gray-500 font-medium">Lapangan</span>
                        </div>
                        <div>
                            <span class="block text-3xl font-bold text-blue-600">10k+</span>
                            <span class="text-sm text-gray-500 font-medium">Penyewa</span>
                        </div>
                        <div>
                            <span class="block text-3xl font-bold text-blue-600">24/7</span>
                            <span class="text-sm text-gray-500 font-medium">Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-12">Tim Dibalik Layar</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-12">
                    <div class="space-y-4">
                        <img class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-100"
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="CEO">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Alex Santoso</h3>
                            <p class="text-blue-600 font-medium">Founder & CEO</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <img class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-100"
                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="CTO">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Sarah Wijaya</h3>
                            <p class="text-blue-600 font-medium">Head of Operations</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <img class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-100"
                            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="Marketing">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Budi Pratama</h3>
                            <p class="text-blue-600 font-medium">Marketing Lead</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footer />
</body>

</html>
