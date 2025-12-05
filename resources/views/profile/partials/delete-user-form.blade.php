<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-white">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus, silakan unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        {{-- Background Modal: Pastikan kontras. Default x-modal biasanya putih, jadi kita pakai text-slate-900 --}}
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-slate-800 text-white">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-white">
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-300">
                {{ __('Setelah akun dihapus, semua data akan hilang permanen. Masukkan password Anda untuk konfirmasi.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-slate-900 border-slate-700 text-white placeholder-slate-500 focus:border-red-500 focus:ring-red-500 rounded-xl"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-slate-700 text-white border-slate-600 hover:bg-slate-600">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>