<x-layouts.public :title="$author->name.' — Kritis Sumsel'">
    <div class="border-b border-secondary bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-8">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary font-heading text-2xl font-bold text-white">
                {{ strtoupper(substr($author->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="font-heading text-2xl font-extrabold text-primary-dark dark:text-white">{{ $author->name }}</h1>
                @if ($author->bio)
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">{{ $author->bio }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8">
        <x-section-title title="Artikel oleh {{ $author->name }}" />
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <x-news-card :article="$article" variant="vertical" />
            @empty
                <p class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400">Belum ada artikel dari penulis ini.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $articles->links() }}</div>
    </div>
</x-layouts.public>
