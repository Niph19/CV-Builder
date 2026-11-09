<x-guest-layout>
    <div class="rounded-2xl border border-white/10 bg-mist/95 p-7 shadow-[0_24px_80px_rgba(0,0,0,0.35)] backdrop-blur-sm sm:p-8">
        <div class="mb-6">
            <h1 class="font-display text-2xl font-semibold text-ink">Masuk</h1>
            <p class="mt-1 text-sm text-forest/70">Siswa dan admin pakai halaman yang sama.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between gap-3">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-forest/30 text-moss shadow-sm focus:ring-mint" name="remember">
                    <span class="ms-2 text-sm text-forest/80">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-moss hover:text-forest" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center">
                Masuk
            </x-primary-button>
        </form>

        <p class="mt-6 text-center text-sm text-forest/70">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-moss hover:text-forest">Daftar sebagai siswa</a>
        </p>
    </div>
</x-guest-layout>
