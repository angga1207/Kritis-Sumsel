<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="color-scheme" content="light dark">
        <link rel="icon" href="{{ \App\Models\Setting::get('site_favicon', '') ?: '/favicon.ico' }}">

        @php
            $siteLogo = \App\Models\Setting::get('site_logo', '');
        @endphp

        @php
            $authTitles = [
                'login' => 'Masuk',
                'register' => 'Daftar',
                'password.request' => 'Lupa Password',
                'password.reset' => 'Atur Ulang Password',
                'password.confirm' => 'Konfirmasi Password',
                'verification.notice' => 'Verifikasi Email',
            ];
        @endphp
        <title>{{ $title ?? $authTitles[request()->route()?->getName()] ?? 'Masuk' }} — Kritis Sumsel</title>

        <script>
            (function () {
                var theme = localStorage.getItem('theme');
                var isDark = theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.classList.toggle('dark', isDark);
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-secondary font-sans antialiased dark:bg-gray-950">
        <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2">
            {{-- Brand panel --}}
            <div class="relative hidden overflow-hidden bg-primary-dark lg:flex lg:flex-col lg:justify-between lg:p-12">
                <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(circle at 20% 20%, rgba(244,180,0,0.18), transparent 45%), radial-gradient(circle at 80% 70%, rgba(19,49,92,0.6), transparent 50%);"></div>

                <a href="{{ route('home') }}" wire:navigate class="relative z-10 flex items-center gap-2.5">
                    @if ($siteLogo)
                        <span class="inline-flex rounded-lg bg-white/95 p-1.5 shadow-sm">
                            <img src="{{ $siteLogo }}" alt="Logo" class="h-7 w-auto max-w-[150px] object-contain">
                        </span>
                    @else
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-accent text-primary-dark">
                            <x-heroicon-s-newspaper class="h-5 w-5" />
                        </span>
                        <span class="font-heading text-xl font-extrabold text-white">
                            Kritis<span class="text-accent">Sumsel</span>
                        </span>
                    @endif
                </a>

                <div class="relative z-10 max-w-md">
                    <h1 class="font-heading text-4xl font-extrabold leading-tight text-white">
                        Kanal berita kritis, akurat, dan terkini seputar Sumatera Selatan.
                    </h1>
                    <p class="mt-4 text-sm leading-relaxed text-white/60">
                        Masuk untuk mengelola artikel, memantau komentar pembaca, dan menjaga informasi tetap terpercaya untuk masyarakat Sumatera Selatan.
                    </p>

                    <ul class="mt-8 space-y-3 text-sm text-white/80">
                        <li class="flex items-center gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/10">
                                <x-heroicon-o-document-text class="h-4 w-4 text-accent" />
                            </span>
                            Kelola artikel dan konten redaksi
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/10">
                                <x-heroicon-o-chart-bar class="h-4 w-4 text-accent" />
                            </span>
                            Pantau analitik dan performa berita
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/10">
                                <x-heroicon-o-chat-bubble-left-right class="h-4 w-4 text-accent" />
                            </span>
                            Moderasi komentar pembaca
                        </li>
                    </ul>
                </div>

                <p class="relative z-10 text-xs text-white/40">&copy; {{ date('Y') }} Kritis Sumsel. Seluruh hak cipta dilindungi.</p>
            </div>

            {{-- Form panel --}}
            <div class="flex flex-col justify-center bg-secondary px-6 py-12 dark:bg-gray-950 sm:px-12 lg:px-16">
                <div class="mx-auto w-full max-w-sm" data-aos="fade-up" data-aos-duration="400">
                    <a href="{{ route('home') }}" wire:navigate class="mb-8 flex items-center gap-2.5 lg:hidden">
                        @if ($siteLogo)
                            <img src="{{ $siteLogo }}" alt="Logo" class="h-9 w-auto max-w-[150px] object-contain">
                        @else
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary text-accent">
                                <x-heroicon-s-newspaper class="h-5 w-5" />
                            </span>
                            <span class="font-heading text-lg font-extrabold text-primary-dark dark:text-white">
                                Kritis<span class="text-accent">Sumsel</span>
                            </span>
                        @endif
                    </a>

                    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-black/5 dark:bg-gray-900 dark:ring-white/10">
                        {{ $slot }}
                    </div>

                    <a href="{{ route('home') }}" wire:navigate class="mt-6 flex items-center justify-center gap-1.5 text-sm text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-accent">
                        <x-heroicon-o-arrow-left class="h-4 w-4" />
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
