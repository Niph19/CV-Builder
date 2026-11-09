<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CV Builder') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|sora:500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink antialiased">
        <div class="auth-atmosphere relative min-h-screen overflow-hidden">
            <div class="auth-grid pointer-events-none absolute inset-0"></div>

            <div class="relative z-10 mx-auto flex min-h-screen w-full max-w-6xl flex-col justify-center px-6 py-12 lg:px-10">
                <div class="grid items-center gap-10 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="text-fog">
                        <p class="font-display text-5xl font-semibold tracking-tight text-white sm:text-6xl lg:text-7xl">
                            {{ config('app.name', 'CV Builder') }}
                        </p>
                        <p class="mt-5 max-w-md text-base leading-relaxed text-fog/80 sm:text-lg">
                            Platform CV dan lamaran kerja untuk siswa SMK Informatika Pesat.
                        </p>
                    </div>

                    <div class="w-full max-w-md justify-self-center lg:justify-self-end">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
