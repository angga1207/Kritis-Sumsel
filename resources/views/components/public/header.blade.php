@php
    $categories = \App\Models\Category::active()->whereNull('parent_id')->with(['children' => fn ($q) => $q->active()->orderBy('order')])->orderBy('order')->get();
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $siteLogo = \App\Models\Setting::get('site_logo', '');
@endphp
<header
    x-data="{
        scrolled: false,
        mobileOpen: false,
        searchOpen: false,
        dark: document.documentElement.classList.contains('dark'),
        toggleDark() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.dark);
        },
    }"
    @scroll.window="scrolled = window.scrollY > 40"
    :class="scrolled ? 'shadow-md shadow-slate-900/5 py-2' : 'py-3'"
    class="sticky top-0 z-50 border-b border-slate-900/5 bg-white/90 backdrop-blur-md transition-all duration-300 dark:border-white/10 dark:bg-gray-950/90">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4">
        <a href="{{ route('home') }}" wire:navigate class="group flex items-center gap-2 shrink-0">
            @if ($siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-9 w-auto max-w-[160px] object-contain transition-transform duration-300 group-hover:scale-105">
            @else
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-light text-white shadow-sm shadow-primary/30 transition-transform duration-300 group-hover:scale-105 group-hover:rotate-3">
                    <x-heroicon-s-bolt class="h-5 w-5" />
                </span>
                <span class="font-heading text-xl font-extrabold tracking-tight text-slate-800 dark:text-white sm:text-2xl">
                    @if (Str::contains($siteName, 'Sumsel'))
                        {{ trim(Str::before($siteName, 'Sumsel')) }}<span class="text-primary">Sumsel</span>
                    @else
                        {{ $siteName }}
                    @endif
                </span>
            @endif
        </a>

        <nav class="hidden items-center gap-1 lg:flex">
            @foreach ($categories as $category)
                <div class="group relative">
                    <a href="{{ route('category.show', $category->slug) }}" wire:navigate
                        class="flex items-center gap-1 rounded-full px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-primary/10 hover:text-primary dark:text-gray-300 dark:hover:bg-white/10 dark:hover:text-accent">
                        {{ $category->name }}
                        @if ($category->children->isNotEmpty())
                            <x-heroicon-s-chevron-down class="h-3 w-3 transition-transform duration-200 group-hover:rotate-180" />
                        @endif
                    </a>
                    @if ($category->children->isNotEmpty())
                        <div class="invisible absolute left-0 top-full z-10 min-w-[180px] translate-y-1 rounded-xl bg-white py-1.5 opacity-0 shadow-lg ring-1 ring-slate-900/5 transition-all duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 dark:bg-gray-800 dark:ring-white/10">
                            @foreach ($category->children as $child)
                                <a href="{{ route('category.show', $child->slug) }}" wire:navigate
                                    class="block px-4 py-2 text-sm text-slate-600 hover:bg-primary/5 hover:text-primary dark:text-gray-100 dark:hover:bg-gray-700">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        <div class="flex items-center gap-1">
            <button @click="searchOpen = !searchOpen" class="rounded-full p-2 text-slate-500 transition hover:bg-primary/10 hover:text-primary dark:text-gray-300 dark:hover:bg-white/10 dark:hover:text-accent" aria-label="Cari">
                <x-heroicon-o-magnifying-glass class="h-5 w-5" />
            </button>

            <button @click="toggleDark()" class="rounded-full p-2 text-slate-500 transition hover:bg-primary/10 hover:text-primary dark:text-gray-300 dark:hover:bg-white/10 dark:hover:text-accent" aria-label="Ganti tema">
                <x-heroicon-o-sun class="h-5 w-5" x-show="dark" x-cloak />
                <x-heroicon-o-moon class="h-5 w-5" x-show="!dark" x-cloak />
            </button>

            @auth
                <a href="{{ auth()->user()->can('articles.viewAny') ? route('admin.dashboard') : route('profile') }}" wire:navigate
                    class="hidden rounded-full bg-primary/10 px-3 py-1.5 text-sm font-semibold text-primary hover:bg-primary/20 dark:bg-white/10 dark:text-accent dark:hover:bg-white/20 sm:inline-flex">
                    {{ auth()->user()->name }}
                </a>
            @else
                <a href="{{ route('login') }}" wire:navigate class="hidden rounded-full bg-primary px-4 py-1.5 text-sm font-semibold text-white shadow-sm shadow-primary/30 transition hover:-translate-y-0.5 hover:bg-primary-light hover:shadow-md sm:inline-flex">
                    Masuk
                </a>
            @endauth

            <button @click="mobileOpen = !mobileOpen" class="rounded-full p-2 text-slate-500 hover:bg-primary/10 hover:text-primary dark:text-gray-300 dark:hover:bg-white/10 lg:hidden" aria-label="Menu">
                <x-heroicon-o-bars-3 class="h-6 w-6" x-show="!mobileOpen" />
                <x-heroicon-o-x-mark class="h-6 w-6" x-show="mobileOpen" x-cloak />
            </button>
        </div>
    </div>

    <div x-show="searchOpen" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="border-t border-slate-900/5 bg-white dark:border-white/10 dark:bg-gray-950">
        <form action="{{ route('search') }}" method="GET" class="mx-auto flex max-w-3xl items-center gap-2 px-4 py-3">
            <x-heroicon-o-magnifying-glass class="h-5 w-5 shrink-0 text-primary" />
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..." autofocus
                class="w-full border-0 border-b-2 border-slate-200 bg-transparent px-1 py-1.5 text-slate-800 placeholder-slate-400 focus:border-primary focus:ring-0 dark:border-gray-700 dark:text-white">
            <button type="submit" class="btn-primary shrink-0">Cari</button>
        </form>
    </div>

    <div x-show="mobileOpen" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="border-t border-slate-900/5 bg-white dark:border-white/10 dark:bg-gray-950 lg:hidden">
        <nav class="flex flex-col px-4 py-2">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" wire:navigate
                    class="rounded-lg px-2 py-2 text-sm font-semibold text-slate-600 hover:bg-primary/10 hover:text-primary dark:text-gray-300 dark:hover:bg-white/10">
                    {{ $category->name }}
                </a>
                @foreach ($category->children as $child)
                    <a href="{{ route('category.show', $child->slug) }}" wire:navigate
                        class="rounded-lg px-2 py-2 pl-6 text-sm text-slate-500 hover:bg-primary/10 hover:text-primary dark:text-gray-400 dark:hover:bg-white/10">
                        &ndash; {{ $child->name }}
                    </a>
                @endforeach
            @endforeach
            @auth
                <a href="{{ route('profile') }}" wire:navigate class="rounded-lg px-2 py-2 text-sm font-semibold text-slate-600 hover:bg-primary/10 hover:text-primary dark:text-gray-300 dark:hover:bg-white/10">Akun Saya</a>
            @else
                <a href="{{ route('login') }}" wire:navigate class="rounded-lg px-2 py-2 text-sm font-semibold text-primary">Masuk</a>
            @endauth
        </nav>
    </div>
</header>
