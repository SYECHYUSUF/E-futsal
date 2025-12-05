<section>
    <header>
        <h2 class="text-lg font-bold text-white">
            {{ __('Perbarui Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Password Saat Ini --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" class="text-slate-300" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" 
                class="mt-1 block w-full bg-slate-900 border-slate-700 text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Password Baru --}}
        <div>
            <x-input-label for="update_password_password" :value="__('Password Baru')" class="text-slate-300" />
            <x-text-input id="update_password_password" name="password" type="password" 
                class="mt-1 block w-full bg-slate-900 border-slate-700 text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-300" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="mt-1 block w-full bg-slate-900 border-slate-700 text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-emerald-600 hover:bg-emerald-500 border-none">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>