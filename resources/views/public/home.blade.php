<x-layouts.public title="Kritis Sumsel — Berita Terkini Sumatera Selatan">
    @if (session('newsletter_verified'))
        <div class="flex items-center justify-center gap-2 bg-success/10 py-3 text-center text-sm font-medium text-success dark:bg-success/20">
            <x-heroicon-s-check-circle class="h-4 w-4" />
            Email Anda berhasil dikonfirmasi. Terima kasih telah berlangganan newsletter Kritis Sumsel!
        </div>
    @endif

    <livewire:frontend.hero-slider />

    @php
        $iconMap = [
            'landmark' => 'building-library',
            'trending-up' => 'arrow-trending-up',
            'gavel' => 'scale',
            'trophy' => 'trophy',
            'graduation-cap' => 'academic-cap',
            'heart-pulse' => 'heart',
            'cpu' => 'cpu-chip',
            'flame' => 'fire',
        ];
    @endphp
    <nav class="sticky top-[57px] z-40 border-b border-slate-900/5 bg-white/90 backdrop-blur-md dark:border-white/10 dark:bg-gray-950/90 sm:top-[65px]" aria-label="Navigasi kategori cepat">
        <div class="scrollbar-none mx-auto flex max-w-7xl items-center gap-2 overflow-x-auto px-4 py-3">
            @foreach ($categories as $category)
                <a href="#kategori-{{ $category->slug }}"
                    class="pill-tab flex shrink-0 items-center gap-1.5 bg-secondary text-slate-600 hover:-translate-y-0.5 hover:shadow-sm dark:bg-white/5 dark:text-gray-300">
                    <x-dynamic-component :component="'heroicon-o-' . ($iconMap[$category->icon] ?? 'tag')" class="h-3.5 w-3.5" style="color: {{ $category->color }}" />
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </nav>

    <livewire:frontend.editors-pick />

    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="space-y-2 lg:col-span-2">
                @foreach ($categories as $category)
                    <livewire:frontend.category-section :category="$category" :key="'cat-'.$category->id" />
                @endforeach
            </div>

            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-40">
                    <livewire:frontend.trending-sidebar />
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>
