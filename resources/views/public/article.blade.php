<x-layouts.public :title="$article->meta_title ?: $article->title" :description="$article->meta_description ?: $article->excerpt" :og-image="$article->featured_image">
    <div class="mx-auto max-w-4xl px-4 py-8">
        <nav class="mb-4 flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
            <x-heroicon-o-home class="h-3.5 w-3.5" />
            <a href="{{ route('home') }}" wire:navigate class="hover:text-primary dark:hover:text-accent">Beranda</a>
            <x-heroicon-o-chevron-right class="h-3 w-3" />
            <a href="{{ route('category.show', $article->category->slug) }}" wire:navigate class="hover:text-primary dark:hover:text-accent">{{ $article->category->name }}</a>
        </nav>

        @if ($article->category)
            <x-category-badge :category="$article->category" />
        @endif

        <h1 class="mt-4 font-heading text-3xl font-extrabold leading-tight text-primary-dark sm:text-4xl dark:text-white" data-aos="fade-up">
            {{ $article->title }}
        </h1>

        <div class="mt-4 flex flex-wrap items-center gap-4 border-b border-secondary pb-4 text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400">
            <a href="{{ route('author.show', $article->author->username ?? $article->author->id) }}" wire:navigate class="flex items-center gap-1.5 font-semibold text-primary-dark hover:text-primary-light dark:text-white dark:hover:text-accent">
                <x-heroicon-s-user-circle class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                {{ $article->author->name ?? 'Redaksi' }}
            </a>
            <span class="flex items-center gap-1"><x-heroicon-o-calendar class="h-3.5 w-3.5" /> <time datetime="{{ $article->published_at }}">{{ $article->published_at?->translatedFormat('d F Y, H:i') }}</time></span>
            <span class="flex items-center gap-1"><x-heroicon-o-eye class="h-3.5 w-3.5" /> {{ number_format($article->views_count) }} views</span>
            <x-share-buttons :url="route('article.show', $article->slug)" :title="$article->title" trigger="ghost" class="ml-auto" />
        </div>

        @if ($article->featured_image)
            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                class="mt-6 aspect-video w-full rounded-lg object-cover" data-aos="fade-up">
        @endif

        <article class="prose prose-slate mt-8 max-w-none prose-headings:font-heading prose-headings:text-primary-dark prose-a:text-primary-light dark:prose-invert dark:prose-headings:text-white dark:prose-a:text-accent">
            {!! $article->content !!}
        </article>

        @if ($article->media->isNotEmpty())
            <div class="mt-8" x-data="{ open: false, active: null }">
                <x-section-title title="Galeri Foto" />
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($article->media as $item)
                        <button type="button" @click="open = true; active = '{{ $item->path }}'" class="aspect-square overflow-hidden rounded-md bg-secondary dark:bg-gray-800">
                            <img src="{{ $item->path }}" alt="{{ $article->title }}" loading="lazy" class="h-full w-full object-cover transition hover:scale-105">
                        </button>
                    @endforeach
                </div>

                <div x-show="open" x-cloak x-transition @click="open = false"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4">
                    <img :src="active" class="max-h-[85vh] max-w-full rounded-lg object-contain">
                </div>
            </div>
        @endif

        <div class="mt-8 flex flex-wrap items-center justify-between gap-3 border-t border-secondary pt-6 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <livewire:frontend.like-bookmark-buttons :article="$article" :key="'like-'.$article->id" />
                <x-share-buttons :url="route('article.show', $article->slug)" :title="$article->title" />
            </div>

            @if ($article->tags->isNotEmpty())
                <div class="hidden flex-wrap gap-2 sm:flex">
                    @foreach ($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}" wire:navigate class="rounded-full bg-secondary px-3 py-1 text-xs font-medium text-primary-dark hover:bg-primary hover:text-white dark:bg-gray-800 dark:text-gray-200">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($related->isNotEmpty())
            <div class="mt-12">
                <x-section-title title="Berita Terkait" />
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($related as $item)
                        <x-news-card :article="$item" variant="vertical" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <livewire:frontend.comment-section :article="$article" :key="'comments-'.$article->id" />
</x-layouts.public>
