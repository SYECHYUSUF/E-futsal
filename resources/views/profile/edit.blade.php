@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header Halaman --}}
        <div class="mb-4">
            <h2 class="text-3xl font-bold text-white">Pengaturan Profil</h2>
            <p class="text-slate-400">Kelola informasi akun dan keamanan Anda di sini.</p>
        </div>

        {{-- Card 1: Update Informasi Profil --}}
        <div class="p-6 sm:p-8 bg-slate-800 rounded-2xl border border-slate-700 shadow-lg">
            <div class="max-w-xl">
                {{-- Form ini memanggil file partial --}}
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Card 2: Update Password --}}
        <div class="p-6 sm:p-8 bg-slate-800 rounded-2xl border border-slate-700 shadow-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Card 3: Hapus Akun --}}
        <div class="p-6 sm:p-8 bg-slate-800 rounded-2xl border border-slate-700 shadow-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection