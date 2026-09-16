<div>
    @if ($tags->isNotEmpty())
        <div class="mb-6 flex flex-wrap gap-2" wire:ignore.self>
            <button wire:click="$set('tag', '')"
                class="rounded-full px-3 py-1 text-xs font-semibold {{ $tag === '' ? 'bg-primary text-white' : 'bg-secondary text-primary-dark dark:bg-gray-800 dark:text-gray-200' }}">
                Semua
            </button>
            @foreach ($tags as $t)
                <button wire:click="$set('tag', '{{ $t->slug }}')"
                    class="rounded-full px-3 py-1 text-xs font-semibold {{ $tag === $t->slug ? 'bg-primary text-white' : 'bg-secondary text-primary-dark dark:bg-gray-800 dark:text-gray-200' }}">
                    #{{ $t->name }}
                </button>
            @endforeach
        </div>
    @endif

    <div wire:loading.delay class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <x-skeleton-card :count="3" />
    </div>

    <div wire:loading.delay.class="opacity-0" class="transition-opacity" data-masonry wire:ignore.self>
        <div class="masonry-sizer w-full sm:w-1/2 lg:w-1/3"></div>
        @forelse ($articles as $article)
            <div wire:key="article-{{ $article->id }}" class="masonry-item w-full px-3 pb-6 sm:w-1/2 lg:w-1/3">
                <x-news-card :article="$article" variant="vertical" />
            </div>
        @empty
            <p class="py-12 text-center text-gray-500 dark:text-gray-400">Belum ada artikel untuk ditampilkan.</p>
        @endforelse
    </div>

    @if ($articles->hasMorePages())
        <div class="mt-8 flex justify-center">
            <button wire:click="loadMore" wire:loading.attr="disabled" wire:target="loadMore" class="btn-outline">
                <span wire:loading.remove wire:target="loadMore">Muat Lebih Banyak</span>
                <span wire:loading wire:target="loadMore">Memuat...</span>
            </button>
        </div>
    @endif
</div>
