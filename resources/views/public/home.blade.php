<x-layouts.public title="Kritis Sumsel — Berita Terkini Sumatera Selatan">
    @if (session('newsletter_verified'))
        <div class="bg-success/10 py-3 text-center text-sm font-medium text-success dark:bg-success/20">
            Email Anda berhasil dikonfirmasi. Terima kasih telah berlangganan newsletter Kritis Sumsel!
        </div>
    @endif

    <livewire:frontend.hero-slider />

    <livewire:frontend.editors-pick />

    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="space-y-2 lg:col-span-2">
                @foreach ($categories as $category)
                    <livewire:frontend.category-section :category="$category" :key="'cat-'.$category->id" />
                @endforeach
            </div>

            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-24">
                    <livewire:frontend.trending-sidebar />
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>
