<div>
    @if ($articles->isNotEmpty())
        <section class="relative overflow-hidden bg-gradient-to-b from-secondary to-white py-12 dark:from-gray-900 dark:to-gray-950">
            <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-primary/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-accent/10 blur-3xl"></div>
            <div class="relative mx-auto max-w-7xl px-4">
                <div class="mb-6 flex items-center gap-3" data-aos="fade-up">
                    <span class="icon-chip !bg-accent/20 !text-accent-warm dark:!bg-accent/20"><x-heroicon-s-star class="h-[18px] w-[18px]" /></span>
                    <span class="font-heading text-2xl font-bold text-slate-800 dark:text-white">Pilihan Editor</span>
                    <span class="h-[3px] flex-1 rounded-full bg-gradient-to-r from-primary via-accent to-transparent"></span>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <div class="news-card group relative" data-aos="fade-up">
                            <a href="{{ route('article.show', $article->slug) }}" wire:navigate class="block">
                                <div class="news-card-thumb">
                                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" loading="lazy">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-heading text-base font-bold leading-snug text-slate-800 line-clamp-2 group-hover:text-primary dark:text-white dark:group-hover:text-accent">
                                        {{ $article->title }}
                                    </h3>
                                    <div class="mt-2 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1"><x-heroicon-o-user class="h-3.5 w-3.5" /> {{ $article->author->name ?? 'Redaksi' }}</span>
                                        <span class="flex items-center gap-1"><x-heroicon-o-clock class="h-3.5 w-3.5" /> {{ $article->published_at?->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                            @if ($article->category)
                                <x-category-badge :category="$article->category" class="absolute left-3 top-3 z-10 shadow" />
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
