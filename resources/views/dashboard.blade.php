<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-wider text-moss">Siswa</p>
                <h2 class="font-display text-xl font-semibold text-ink">Dashboard Siswa</h2>
            </div>
            <span class="rounded-full bg-mint/15 px-3 py-1 text-xs font-semibold text-moss">
                {{ Auth::user()->role->label() }}
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-forest/10 bg-white p-6 shadow-sm">
                <p class="text-sm text-forest/70">Halo, {{ Auth::user()->name }}.</p>
                <p class="mt-2 text-base text-ink">
                    Akun siswa aktif. Fitur CV Builder, analisis AI, dan lamaran kelas bekerja akan ditambahkan di sprint berikutnya.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
