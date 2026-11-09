<x-guest-layout>
    <div class="rounded-2xl border border-white/10 bg-mist/95 p-7 shadow-[0_24px_80px_rgba(0,0,0,0.35)] backdrop-blur-sm sm:p-8">
        <div class="mb-6">
            <h1 class="font-display text-2xl font-semibold text-ink">Daftar Akun</h1>
            <p class="mt-1 text-sm text-forest/70">Buat akun siswa atau alumni SMK Informatika Pesat.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="name" value="Nama lengkap" />
                <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="role" value="Status" />
                <select id="role" name="role" class="mt-1 block w-full rounded-lg border-forest/25 bg-white text-ink shadow-sm focus:border-moss focus:ring-moss" required>
                    <option value="siswa" @selected(old('role', 'siswa') === 'siswa')>Siswa aktif</option>
                    <option value="alumni" @selected(old('role') === 'alumni')>Alumni</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
                <p class="mt-1 text-xs text-forest/60">Minimal 8 karakter.</p>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi password" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center">
                Buat akun
            </x-primary-button>
        </form>

        <p class="mt-6 text-center text-sm text-forest/70">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-moss hover:text-forest">Masuk</a>
        </p>
    </div>
</x-guest-layout>
