<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-wider text-moss">Akun</p>
                <h2 class="font-display text-xl font-semibold text-ink">Pengaturan Profil</h2>
            </div>
            @unless (Auth::user()->isAdmin())
                <a href="{{ route('profile.data.edit') }}" class="rounded-lg bg-moss px-4 py-2 text-sm font-semibold text-white hover:bg-forest">
                    Isi data diri CV
                </a>
            @endunless
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @unless (Auth::user()->isAdmin())
                <div class="rounded-2xl border border-mint/40 bg-mint/10 p-5">
                    <p class="text-sm text-forest/80">
                        Lengkapi <a href="{{ route('profile.data.edit') }}" class="font-semibold text-moss underline">data diri</a>
                        (pendidikan, pengalaman, skill) agar CV Builder dan analisis AI dapat memakai datamu.
                    </p>
                </div>
            @endunless

            <div class="rounded-2xl border border-forest/10 bg-white p-5 shadow-sm sm:p-7">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-2xl border border-forest/10 bg-white p-5 shadow-sm sm:p-7">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-2xl border border-forest/10 bg-white p-5 shadow-sm sm:p-7">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
