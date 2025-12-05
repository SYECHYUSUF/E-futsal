@extends('layouts.admin')

@section('content')
<div class="p-6">
    {{-- HEADER --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen User</h1>
            <p class="text-slate-400">Daftar pengguna yang terdaftar sebagai customer.</p>
        </div>
    </div>

    {{-- ALERT MESSAGES --}}
    @if (session('success'))
    <div class="mb-4 bg-emerald-800/50 border border-emerald-700 text-emerald-400 px-4 py-3 rounded-lg relative"
        role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    {{-- TABLE CONTAINER --}}
    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-400">
                <thead class="bg-slate-700/50 text-slate-200 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Nama User</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center text-emerald-500 font-bold border border-slate-600">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">
                                        Bergabung: {{ $user->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-300">{{ $user->email }}</div>
                            <div class="text-xs text-slate-500">{{ $user->phone ?? 'No Phone' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{-- Cek apakah kolom is_active ada di database. Jika tidak ada, logic ini mungkin perlu dihapus --}}
                            @if(isset($user->is_active) && $user->is_active)
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Aktif
                            </span>
                            @else
                            {{-- Default jika pending atau kolom is_active false --}}
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-orange-500/10 text-orange-400 border border-orange-500/20">
                                Pending / Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex items-center gap-3">

                            {{-- Tombol Approve (Hanya muncul jika user belum aktif) --}}
                            {{-- PENTING: Pastikan Anda membuat route 'admin.users.approve' di web.php jika ingin menggunakan fitur ini --}}
                            @if(isset($user->is_active) && !$user->is_active)
                            @if(Route::has('admin.users.approve'))
                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="text-emerald-400 hover:text-emerald-300 text-xs font-bold uppercase transition-colors">
                                    Approve
                                </button>
                            </form>
                            @endif
                            @endif

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-400 hover:text-red-300 transition-colors"
                                    title="Hapus User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            Tidak ada user customer yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection