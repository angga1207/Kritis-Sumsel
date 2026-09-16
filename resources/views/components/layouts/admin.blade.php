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
    <title>{{ $title ?? 'Dashboard' }} — Kritis Sumsel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-secondary font-sans antialiased transition-colors duration-200 dark:bg-gray-950"
    x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('admin-sidebar-collapsed') === 'true',
        dark: document.documentElement.classList.contains('dark'),
        toggleCollapse() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('admin-sidebar-collapsed', this.sidebarCollapsed);
        },
        toggleDark() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.dark);
        },
    }">
    <div class="flex min-h-screen">
        {{-- Mobile overlay --}}
        <div x-cloak x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-primary-dark/50 backdrop-blur-sm lg:hidden"></div>

        {{-- Sidebar --}}
        <aside :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0', sidebarCollapsed ? 'lg:w-20' : 'lg:w-64']"
            class="fixed inset-y-0 left-0 z-40 flex w-64 transform flex-col bg-primary-dark transition-all duration-300 ease-in-out">

            <div class="flex h-16 shrink-0 items-center gap-2.5 px-5" :class="sidebarCollapsed && 'lg:justify-center lg:px-0'">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-accent text-primary-dark">
                    <x-heroicon-s-newspaper class="h-5 w-5" />
                </span>
                <span class="font-heading text-lg font-extrabold text-white transition-opacity duration-200" x-show="!sidebarCollapsed" x-cloak>
                    Kritis<span class="text-accent">Sumsel</span>
                </span>
            </div>

            <nav class="mt-2 flex-1 space-y-6 overflow-y-auto px-3 pb-4">
                @php
                    $groups = [
                        'Ringkasan' => [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'squares-2x2'],
                            ['route' => 'admin.analytics.index', 'label' => 'Analitik', 'icon' => 'chart-bar'],
                        ],
                        'Konten' => [
                            ['route' => 'admin.articles.index', 'label' => 'Artikel', 'icon' => 'document-text'],
                            ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => 'tag'],
                            ['route' => 'admin.tags.index', 'label' => 'Tag', 'icon' => 'hashtag'],
                            ['route' => 'admin.comments.index', 'label' => 'Komentar', 'icon' => 'chat-bubble-left-right', 'badge' => $pendingCommentsCount ?? 0],
                        ],
                        'Sistem' => [
                            ['route' => 'admin.users.index', 'label' => 'Pengguna', 'icon' => 'users'],
                            ['route' => 'admin.settings.index', 'label' => 'Pengaturan', 'icon' => 'cog-6-tooth'],
                        ],
                    ];
                @endphp

                @foreach ($groups as $groupLabel => $links)
                    <div>
                        <p class="mb-1.5 px-3 text-[10px] font-bold uppercase tracking-widest text-white/30" x-show="!sidebarCollapsed" x-cloak>{{ $groupLabel }}</p>
                        <div class="space-y-1">
                            @foreach ($links as $link)
                                @php
                                    $isActive = request()->routeIs(str($link['route'])->before('.index').'*') || request()->routeIs($link['route']);
                                @endphp
                                <a href="{{ route($link['route']) }}" wire:navigate
                                    :class="sidebarCollapsed && 'lg:justify-center lg:px-0'"
                                    title="{{ $link['label'] }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ $isActive ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                                    @if ($isActive)
                                        <span class="absolute inset-y-1 left-0 w-1 rounded-r bg-accent"></span>
                                    @endif
                                    <x-dynamic-component :component="'heroicon-o-' . $link['icon']" class="h-5 w-5 shrink-0 {{ $isActive ? 'text-accent' : '' }}" />
                                    <span class="truncate transition-opacity duration-200" x-show="!sidebarCollapsed" x-cloak>{{ $link['label'] }}</span>
                                    @if (!empty($link['badge']) && $link['badge'] > 0)
                                        <span x-show="!sidebarCollapsed" x-cloak class="ml-auto flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-danger px-1 text-[10px] font-bold text-white">
                                            {{ $link['badge'] > 99 ? '99+' : $link['badge'] }}
                                        </span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <div class="shrink-0 border-t border-white/10 p-3">
                <button @click="toggleCollapse()" class="hidden w-full items-center justify-center gap-2 rounded-lg py-2 text-xs font-medium text-white/50 transition hover:bg-white/5 hover:text-white lg:flex">
                    <x-heroicon-o-chevron-double-left class="h-4 w-4 transition-transform duration-300" x-bind:class="sidebarCollapsed && 'rotate-180'" />
                    <span x-show="!sidebarCollapsed" x-cloak>Ciutkan</span>
                </button>
                <a href="{{ route('home') }}" wire:navigate
                    class="mt-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-white/60 transition hover:bg-white/5 hover:text-white"
                    :class="sidebarCollapsed && 'lg:justify-center lg:px-0'" title="Kembali ke situs">
                    <x-heroicon-o-arrow-left-circle class="h-5 w-5 shrink-0" />
                    <span x-show="!sidebarCollapsed" x-cloak>Kembali ke situs</span>
                </a>
            </div>
        </aside>

        <div class="flex min-h-screen min-w-0 flex-1 flex-col transition-all duration-300 lg:pl-64" :class="sidebarCollapsed && 'lg:!pl-20'">
            {{-- Header --}}
            <header class="sticky top-0 z-20 flex h-16 shrink-0 items-center justify-between gap-3 border-b border-secondary bg-white/80 px-4 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/80 sm:px-6">
                <div class="flex min-w-0 items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-gray-500 transition hover:bg-secondary dark:text-gray-400 dark:hover:bg-gray-800 lg:hidden">
                        <x-heroicon-o-bars-3 class="h-6 w-6" />
                    </button>
                    <div class="min-w-0">
                        <nav class="flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
                            <span>Admin</span>
                            <x-heroicon-s-chevron-right class="h-3 w-3" />
                            <span class="font-medium text-primary-dark dark:text-gray-300">{{ $title ?? 'Dashboard' }}</span>
                        </nav>
                        <h1 class="truncate font-heading text-lg font-bold text-primary-dark dark:text-white">{{ $title ?? 'Dashboard' }}</h1>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-1 sm:gap-2">
                    <a href="{{ route('home') }}" target="_blank"
                        class="hidden items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold text-gray-500 transition hover:bg-secondary hover:text-primary dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-accent sm:flex">
                        <x-heroicon-o-globe-alt class="h-4 w-4" />
                        Lihat Situs
                    </a>

                    <button @click="toggleDark()" class="rounded-lg p-2.5 text-gray-500 transition hover:bg-secondary hover:text-primary dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-accent" aria-label="Ganti tema" title="Ganti tema">
                        <x-heroicon-o-sun class="h-5 w-5" x-show="dark" x-cloak />
                        <x-heroicon-o-moon class="h-5 w-5" x-show="!dark" x-cloak />
                    </button>

                    <a href="{{ route('admin.comments.index') }}" wire:navigate
                        class="relative rounded-lg p-2.5 text-gray-500 transition hover:bg-secondary hover:text-primary dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-accent" title="Komentar pending">
                        <x-heroicon-o-bell class="h-5 w-5" />
                        @if (($pendingCommentsCount ?? 0) > 0)
                            <span class="absolute right-1.5 top-1.5 flex h-2 w-2 rounded-full bg-danger">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-danger opacity-75"></span>
                            </span>
                        @endif
                    </a>

                    <div class="h-8 w-px bg-secondary dark:bg-gray-800"></div>

                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center gap-2.5 rounded-lg py-1.5 pl-1.5 pr-2 transition hover:bg-secondary dark:hover:bg-gray-800">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-white">
                                {{ collect(explode(' ', auth()->user()->name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}
                            </span>
                            <span class="hidden text-left sm:block">
                                <span class="block text-sm font-semibold leading-tight text-primary-dark dark:text-white">{{ auth()->user()->name }}</span>
                                <span class="block text-[11px] leading-tight text-gray-400 dark:text-gray-500">{{ auth()->user()->roles->first()?->name ?? 'Admin' }}</span>
                            </span>
                            <x-heroicon-s-chevron-down class="hidden h-4 w-4 text-gray-400 transition-transform sm:block" x-bind:class="open && 'rotate-180'" />
                        </button>

                        <div x-cloak x-show="open" x-transition.origin.top.right
                            class="absolute right-0 z-30 mt-2 w-52 overflow-hidden rounded-xl bg-white py-1.5 shadow-lg ring-1 ring-black/5 dark:bg-gray-800 dark:ring-white/10">
                            <div class="border-b border-secondary px-4 py-3 dark:border-gray-700 sm:hidden">
                                <p class="text-sm font-semibold text-primary-dark dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 transition hover:bg-secondary dark:text-gray-300 dark:hover:bg-gray-700">
                                <x-heroicon-o-user-circle class="h-4 w-4" />
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2.5 px-4 py-2 text-sm text-danger transition hover:bg-danger/5 dark:hover:bg-danger/10">
                                    <x-heroicon-o-arrow-right-on-rectangle class="h-4 w-4" />
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
