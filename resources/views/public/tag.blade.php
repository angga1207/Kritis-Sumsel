<x-layouts.public :title="'#'.$tag->name.' — Kritis Sumsel'">
    <div class="border-b border-secondary bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 py-8">
            <h1 class="flex items-center gap-2 font-heading text-3xl font-extrabold text-primary-dark dark:text-white">
                <x-heroicon-s-hashtag class="h-7 w-7 text-primary-light dark:text-accent" />{{ $tag->name }}
            </h1>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <livewire:frontend.article-list :tag="$tag->slug" />
            </div>
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-24">
                    <livewire:frontend.trending-sidebar />
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>
