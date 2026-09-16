<div class="mx-auto max-w-5xl px-4 py-10">
    <h1 class="mb-6 flex items-center gap-2 font-heading text-2xl font-bold text-primary-dark dark:text-white">
        <x-heroicon-o-magnifying-glass class="h-6 w-6 text-primary dark:text-accent" />
        Pencarian Berita
    </h1>

    <div class="mb-8 flex flex-col gap-3 sm:flex-row">
        <input type="text" wire:model.live.debounce.400ms="query" placeholder="Ketik kata kunci pencarian..."
            class="flex-1 rounded-md border-gray-300 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-900 dark:text-white">
        <select wire:model.live="categorySlug" class="rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div wire:loading.delay class="space-y-4">
        <x-skeleton-card :count="3" />
    </div>

    <div wire:loading.remove wire:loading.delay class="space-y-1 divide-y divide-secondary dark:divide-gray-800">
        @if (trim($query) === '')
            <p class="py-12 text-center text-gray-500 dark:text-gray-400">Masukkan kata kunci untuk mulai mencari.</p>
        @elseif ($results->isEmpty())
            <p class="py-12 text-center text-gray-500 dark:text-gray-400">Tidak ditemukan hasil untuk "{{ $query }}".</p>
        @else
            <p class="pb-4 text-sm text-gray-500 dark:text-gray-400">Menampilkan {{ $results->count() }} dari {{ $results->total() }} hasil untuk "{{ $query }}"</p>
            @foreach ($results as $article)
                <div class="py-4">
                    <x-news-card :article="$article" variant="horizontal" />
                </div>
            @endforeach

            @if ($results->hasMorePages())
                <div class="flex justify-center pt-6">
                    <button wire:click="loadMore" class="btn-outline">Muat Lebih Banyak</button>
                </div>
            @endif
        @endif
    </div>
</div>
