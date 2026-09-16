<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="{{ $description ?? 'Kritis Sumsel — Kanal berita terkini seputar Sumatera Selatan: politik, ekonomi, hukum, olahraga, dan peristiwa.' }}">

    <meta property="og:title" content="{{ $title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? 'Kanal berita terkini seputar Sumatera Selatan.' }}">
    <meta property="og:type" content="website">
    @isset($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endisset

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-secondary/40 font-sans text-[#1A1A1A] antialiased">

    <x-public.header />

    <livewire:frontend.breaking-ticker />

    <main>
        {{ $slot }}
    </main>

    <x-public.footer />

    @livewireScripts
</body>
</html>
