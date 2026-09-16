<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <script>
        (function () {
            var theme = localStorage.getItem('theme');
            var isDark = theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>

    @php
        $pageTitle = $title ?? \App\Models\Setting::get('site_name', config('app.name'));
        $pageDescription = $description ?? \App\Models\Setting::get('meta_description_default', 'Kritis Sumsel — Kanal berita terkini seputar Sumatera Selatan: politik, ekonomi, hukum, olahraga, dan peristiwa.');
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ \App\Models\Setting::get('site_name', config('app.name')) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @isset($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endisset

    <meta name="twitter:card" content="{{ isset($ogImage) ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    @isset($ogImage)
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endisset

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @php($analyticsCode = \App\Models\Setting::get('analytics_code', ''))
    @if ($analyticsCode)
        {!! $analyticsCode !!}
    @endif
</head>
<body class="min-h-screen bg-secondary font-sans text-[#1A1A1A] antialiased transition-colors duration-200 dark:bg-gray-950 dark:text-gray-100">

    <x-public.header />

    <livewire:frontend.breaking-ticker />

    <main>
        {{ $slot }}
    </main>

    <x-public.footer />

    @livewireScripts
</body>
</html>
