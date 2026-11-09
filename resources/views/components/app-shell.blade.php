@props([
    'title' => null,
    'eyebrow' => null,
    'heading' => null,
    'description' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? $heading ?? config('app.name', 'CV Builder') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|sora:500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-mist font-sans text-ink antialiased">
        <div class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-forest from-60% to-forest/0"></div>
            <div class="auth-grid pointer-events-none absolute inset-x-0 top-0 h-72 opacity-40"></div>

            <div class="relative z-10 mx-auto w-full max-w-6xl px-4 pb-16 sm:px-6 lg:px-8">
                <header class="flex items-center justify-between py-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-mint font-display text-base font-bold text-forest shadow-lg shadow-black/20">
                            CV
                        </span>
                        <span class="font-display text-base font-semibold text-white sm:text-lg">
                            {{ config('app.name', 'CV Builder') }}
                        </span>
                    </a>

                    <div class="flex items-center gap-3">
                        @isset($actions)
                            {{ $actions }}
                        @endisset

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-3 py-2 text-sm font-medium text-fog backdrop-blur transition hover:border-white/30 hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-mint">
                                    <span class="grid h-7 w-7 place-items-center rounded-full bg-mint text-xs font-bold text-forest">
                                        {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                                    </span>
                                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <p class="px-4 pb-2 pt-3 text-xs font-semibold uppercase tracking-wider text-forest/50">
                                    {{ auth()->user()->role->label() }}
                                </p>

                                <x-dropdown-link :href="route('profile.edit')">
                                    Pengaturan akun
                                </x-dropdown-link>

                                @unless (auth()->user()->isAdmin())
                                    <x-dropdown-link :href="route('profile.data.edit')">
                                        Data diri
                                    </x-dropdown-link>
                                @endunless

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        Keluar
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <main class="pt-6">
                    @if ($heading)
                        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                @if ($eyebrow)
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-mint">{{ $eyebrow }}</p>
                                @endif
                                <h1 class="mt-2 font-display text-2xl font-semibold text-white sm:text-3xl">{{ $heading }}</h1>
                                @if ($description)
                                    <p class="mt-2 max-w-2xl text-sm leading-relaxed text-fog/80">{{ $description }}</p>
                                @endif
                            </div>

                            @isset($headingActions)
                                <div class="flex flex-wrap items-center gap-3">{{ $headingActions }}</div>
                            @endisset
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
