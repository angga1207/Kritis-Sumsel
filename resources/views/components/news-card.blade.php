@props(['article', 'variant' => 'vertical', 'aos' => 'fade-up'])

@php
    $url = route('article.show', $article->slug);
@endphp

@if ($variant === 'vertical')
    <div class="news-card group relative" data-aos="{{ $aos }}">
        <a href="{{ $url }}" wire:navigate class="block">
            <div class="news-card-thumb">
                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" loading="lazy">
            </div>
            <div class="p-4">
                <h3 class="font-heading text-lg font-bold leading-snug text-primary-dark line-clamp-2 group-hover:text-primary-light dark:text-white dark:group-hover:text-accent">
                    {{ $article->title }}
                </h3>
                <p class="mt-2 line-clamp-2 text-sm text-gray-600 dark:text-gray-400">{{ $article->excerpt }}</p>
                <div class="mt-3 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1"><x-heroicon-o-user class="h-3.5 w-3.5" /> {{ $article->author->name ?? 'Redaksi' }}</span>
                    <span class="flex items-center gap-1"><x-heroicon-o-clock class="h-3.5 w-3.5" /> <time datetime="{{ $article->published_at }}">{{ $article->published_at?->diffForHumans() }}</time></span>
                </div>
            </div>
        </a>
        @if ($article->category)
            <x-category-badge :category="$article->category" class="absolute left-3 top-3 z-10 shadow" />
        @endif
        <x-share-buttons :url="$url" :title="$article->title" trigger="icon" class="absolute right-3 top-3 z-10 opacity-0 transition-opacity duration-200 group-hover:opacity-100" />
    </div>
@elseif ($variant === 'horizontal')
    <div class="group relative flex gap-4" data-aos="{{ $aos }}">
        <a href="{{ $url }}" wire:navigate class="flex gap-4">
            <div class="relative h-24 w-32 shrink-0 overflow-hidden rounded-md bg-secondary dark:bg-gray-800 sm:h-28 sm:w-40">
                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" loading="lazy"
                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="min-w-0">
                <h3 class="font-heading text-base font-bold leading-snug text-primary-dark line-clamp-2 group-hover:text-primary-light dark:text-white dark:group-hover:text-accent">
                    {{ $article->title }}
                </h3>
                <time class="mt-1 block text-xs text-gray-500 dark:text-gray-400">{{ $article->published_at?->diffForHumans() }}</time>
            </div>
        </a>
        @if ($article->category)
            <x-category-badge :category="$article->category" class="absolute left-0 top-0 z-10 !px-1.5 !py-0.5 !text-[10px]" />
        @endif
    </div>
@else
    {{-- compact list --}}
    <article class="flex items-start gap-3 border-b border-secondary py-3 last:border-0 dark:border-gray-800" data-aos="{{ $aos }}">
        <a href="{{ $url }}" wire:navigate class="min-w-0 flex-1">
            <h3 class="text-sm font-semibold leading-snug text-primary-dark line-clamp-2 hover:text-primary-light dark:text-white dark:hover:text-accent">
                {{ $article->title }}
            </h3>
            <time class="mt-1 block text-xs text-gray-500 dark:text-gray-400">{{ $article->published_at?->diffForHumans() }}</time>
        </a>
    </article>
@endif
