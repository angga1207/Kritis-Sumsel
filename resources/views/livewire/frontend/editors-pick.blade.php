<div>
    @if ($articles->isNotEmpty())
        <section class="bg-primary-dark py-10">
            <div class="mx-auto max-w-7xl px-4">
                <div class="mb-6 flex items-center gap-3" data-aos="fade-up">
                    <x-heroicon-s-star class="h-6 w-6 text-accent" />
                    <span class="font-heading text-2xl font-bold text-white">Pilihan Editor</span>
                    <span class="h-[3px] flex-1 rounded bg-gradient-to-r from-accent to-transparent"></span>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <div class="group relative overflow-hidden rounded-lg bg-white/5 ring-1 ring-white/10 transition hover:bg-white/10" data-aos="fade-up">
                            <a href="{{ route('article.show', $article->slug) }}" wire:navigate class="block">
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" loading="lazy"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-heading text-base font-bold leading-snug text-white line-clamp-2 group-hover:text-accent">
                                        {{ $article->title }}
                                    </h3>
                                    <div class="mt-2 flex items-center gap-2 text-xs text-white/60">
                                        <span>{{ $article->author->name ?? 'Redaksi' }}</span>
                                        <span>&middot;</span>
                                        <time>{{ $article->published_at?->diffForHumans() }}</time>
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
