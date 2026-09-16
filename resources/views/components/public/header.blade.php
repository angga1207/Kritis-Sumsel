@php
    $categories = \App\Models\Category::active()->whereNull('parent_id')->with(['children' => fn ($q) => $q->active()->orderBy('order')])->orderBy('order')->get();
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
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
    :class="scrolled ? 'shadow-md py-2' : 'py-4'"
    class="sticky top-0 z-50 bg-primary transition-all duration-300">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4">
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 shrink-0">
            <span class="font-heading text-xl font-extrabold tracking-tight text-white sm:text-2xl">
                @if (Str::contains($siteName, 'Sumsel'))
                    {{ trim(Str::before($siteName, 'Sumsel')) }}<span class="text-accent">Sumsel</span>{{ trim(Str::after($siteName, 'Sumsel')) }}
                @else
                    {{ $siteName }}
                @endif
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex">
            @foreach ($categories as $category)
                <div class="group relative">
                    <a href="{{ route('category.show', $category->slug) }}" wire:navigate
                        class="flex items-center gap-1 rounded px-3 py-2 text-sm font-medium text-white/90 transition hover:bg-white/10 hover:text-accent">
                        {{ $category->name }}
                        @if ($category->children->isNotEmpty())
                            <x-heroicon-s-chevron-down class="h-3 w-3" />
                        @endif
                    </a>
                    @if ($category->children->isNotEmpty())
                        <div class="invisible absolute left-0 top-full z-10 min-w-[180px] rounded-md bg-white py-1 opacity-0 shadow-lg ring-1 ring-black/5 transition-all duration-150 group-hover:visible group-hover:opacity-100 dark:bg-gray-800 dark:ring-white/10">
                            @foreach ($category->children as $child)
                                <a href="{{ route('category.show', $child->slug) }}" wire:navigate
                                    class="block px-4 py-2 text-sm text-primary-dark hover:bg-secondary dark:text-gray-100 dark:hover:bg-gray-700">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>

        <div class="flex items-center gap-1">
            <button @click="searchOpen = !searchOpen" class="rounded-full p-2 text-white transition hover:bg-white/10" aria-label="Cari">
                <x-heroicon-o-magnifying-glass class="h-5 w-5" />
            </button>

            <button @click="toggleDark()" class="rounded-full p-2 text-white transition hover:bg-white/10" aria-label="Ganti tema">
                <x-heroicon-o-sun class="h-5 w-5" x-show="dark" x-cloak />
                <x-heroicon-o-moon class="h-5 w-5" x-show="!dark" x-cloak />
            </button>

            @auth
                <a href="{{ auth()->user()->can('articles.viewAny') ? route('admin.dashboard') : route('profile') }}" wire:navigate
                    class="hidden rounded-md bg-white/10 px-3 py-1.5 text-sm font-medium text-white hover:bg-white/20 sm:inline-flex">
                    {{ auth()->user()->name }}
                </a>
            @else
                <a href="{{ route('login') }}" wire:navigate class="hidden rounded-md bg-accent px-3 py-1.5 text-sm font-semibold text-primary-dark hover:brightness-95 sm:inline-flex">
                    Masuk
                </a>
            @endauth

            <button @click="mobileOpen = !mobileOpen" class="rounded-full p-2 text-white lg:hidden" aria-label="Menu">
                <x-heroicon-o-bars-3 class="h-6 w-6" x-show="!mobileOpen" />
                <x-heroicon-o-x-mark class="h-6 w-6" x-show="mobileOpen" x-cloak />
            </button>
        </div>
    </div>

    <div x-show="searchOpen" x-transition x-cloak class="border-t border-white/10 bg-primary-dark">
        <form action="{{ route('search') }}" method="GET" class="mx-auto flex max-w-3xl items-center gap-2 px-4 py-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..." autofocus
                class="w-full rounded-md border-0 bg-white/10 px-4 py-2 text-white placeholder-white/60 focus:bg-white focus:text-primary focus:ring-2 focus:ring-accent">
            <button type="submit" class="btn-accent shrink-0">Cari</button>
        </form>
    </div>

    <div x-show="mobileOpen" x-transition x-cloak class="border-t border-white/10 bg-primary-dark lg:hidden">
        <nav class="flex flex-col px-4 py-2">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" wire:navigate
                    class="rounded px-2 py-2 text-sm font-medium text-white/90 hover:bg-white/10">
                    {{ $category->name }}
                </a>
                @foreach ($category->children as $child)
                    <a href="{{ route('category.show', $child->slug) }}" wire:navigate
                        class="rounded px-2 py-2 pl-6 text-sm text-white/70 hover:bg-white/10">
                        &ndash; {{ $child->name }}
                    </a>
                @endforeach
            @endforeach
            @auth
                <a href="{{ route('profile') }}" wire:navigate class="rounded px-2 py-2 text-sm font-medium text-white/90 hover:bg-white/10">Akun Saya</a>
            @else
                <a href="{{ route('login') }}" wire:navigate class="rounded px-2 py-2 text-sm font-medium text-accent">Masuk</a>
            @endauth
        </nav>
    </div>
</header>
