<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'CV Builder') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|sora:500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink antialiased">
        <div class="auth-atmosphere relative min-h-screen overflow-hidden">
            <div class="auth-grid pointer-events-none absolute inset-0"></div>

            <div class="relative z-10 mx-auto flex min-h-screen w-full max-w-6xl flex-col px-6 py-8 lg:px-10">
                <header class="flex items-center justify-between">
                    <a href="/" class="font-display text-lg font-semibold text-white">{{ config('app.name', 'CV Builder') }}</a>

                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('home') }}" class="rounded-lg bg-mint px-4 py-2 text-sm font-semibold text-forest hover:bg-white">
                                Buka aplikasi
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-fog hover:text-white">Masuk</a>
                            <a href="{{ route('register') }}" class="rounded-lg bg-mint px-4 py-2 text-sm font-semibold text-forest hover:bg-white">
                                Daftar
                            </a>
                        @endauth
                    </nav>
                </header>

                <main class="flex flex-1 flex-col justify-center py-16">
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-mint">SMK Informatika Pesat</p>
                    <h1 class="mt-4 max-w-3xl font-display text-4xl font-semibold leading-tight text-white sm:text-5xl lg:text-6xl">
                        CV, lamaran kerja, dan data alumni dalam satu platform.
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-relaxed text-fog/80 sm:text-lg">
                        Buat CV dengan bantuan AI, temukan lowongan mitra industri, dan lacak lamaran
                        kelas bekerja tanpa spreadsheet.
                    </p>

                    <div class="mt-10 flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="rounded-lg bg-mint px-6 py-3 text-sm font-semibold text-forest hover:bg-white">
                            Mulai sekarang
                        </a>
                        <a href="{{ route('login') }}" class="rounded-lg border border-fog/30 px-6 py-3 text-sm font-semibold text-fog hover:border-fog/60 hover:text-white">
                            Saya sudah punya akun
                        </a>
                    </div>

                    <ul class="mt-16 grid gap-4 sm:grid-cols-3">
                        @foreach ([
                            ['CV Builder + AI', 'Susun CV dan ketahui kelemahannya lewat analisis AI.'],
                            ['Lowongan & Lamaran', 'Lihat lowongan mitra industri dan pantau status lamaran.'],
                            ['Data Alumni', 'Data siswa dan alumni tercatat rapi untuk sekolah.'],
                        ] as [$title, $description])
                            <li class="rounded-2xl border border-fog/15 bg-white/5 p-5 backdrop-blur-sm">
                                <p class="font-display text-base font-semibold text-white">{{ $title }}</p>
                                <p class="mt-2 text-sm leading-relaxed text-fog/70">{{ $description }}</p>
                            </li>
                        @endforeach
                    </ul>
                </main>

                <footer class="pb-2 text-xs text-fog/50">
                    &copy; {{ date('Y') }} {{ config('app.name', 'CV Builder') }}
                </footer>
            </div>
        </div>
    </body>
</html>
