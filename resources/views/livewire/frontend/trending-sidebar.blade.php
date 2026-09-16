<div class="space-y-8" data-aos="fade-left">
    <div class="surface-card p-5">
        <h3 class="mb-4 flex items-center gap-2 font-heading text-lg font-bold text-primary-dark dark:text-white">
            <span class="icon-chip !bg-danger/10 !text-danger"><x-heroicon-s-fire class="h-[18px] w-[18px]" /></span>
            Berita Terpopuler
        </h3>
        <ol class="space-y-4">
            @foreach ($trending as $trendIndex => $trendArticle)
                <li class="flex gap-3">
                    <span class="font-heading text-2xl font-extrabold text-secondary [-webkit-text-stroke:1px_#0D9488] dark:text-gray-800 dark:[-webkit-text-stroke:1px_#FBBF24]">{{ $trendIndex + 1 }}</span>
                    <a href="{{ route('article.show', $trendArticle->slug) }}" wire:navigate class="min-w-0">
                        <h4 class="text-sm font-semibold leading-snug text-primary-dark line-clamp-2 hover:text-primary-light dark:text-gray-100 dark:hover:text-accent">{{ $trendArticle->title }}</h4>
                        <span class="mt-1 flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                            <x-heroicon-o-eye class="h-3.5 w-3.5" /> {{ number_format($trendArticle->views_count) }} views
                        </span>
                    </a>
                </li>
            @endforeach
        </ol>
    </div>

    <div class="surface-card p-5">
        <h3 class="mb-4 flex items-center gap-2 font-heading text-lg font-bold text-primary-dark dark:text-white">
            <span class="icon-chip !bg-primary-light/10 !text-primary-light dark:!text-accent"><x-heroicon-s-hashtag class="h-[18px] w-[18px]" /></span>
            Tag Populer
        </h3>
        <div class="flex flex-wrap gap-2">
            @foreach ($tags as $tagItem)
                <a href="{{ route('tag.show', $tagItem->slug) }}" wire:navigate class="rounded-full bg-secondary px-3 py-1 text-xs font-medium text-primary-dark hover:bg-primary hover:text-white dark:bg-gray-800 dark:text-gray-200">
                    #{{ $tagItem->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>
