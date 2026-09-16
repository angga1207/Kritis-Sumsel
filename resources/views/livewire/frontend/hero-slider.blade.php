<div>
    @if ($articles->isNotEmpty())
        <section class="bg-primary" x-data="{ active: 0, count: {{ $articles->count() }} }"
            x-init="setInterval(() => active = (active + 1) % count, 6000)">
            <div class="relative mx-auto max-w-7xl">
                @foreach ($articles as $index => $article)
                    <div x-show="active === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
                        class="relative aspect-[16/9] w-full overflow-hidden sm:aspect-[21/9]">
                        <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                            class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-dark via-primary-dark/40 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-10">
                            @if ($article->category)
                                <x-category-badge :category="$article->category" class="mb-3" />
                            @endif
                            <a href="{{ route('article.show', $article->slug) }}" wire:navigate>
                                <h1 class="max-w-3xl font-heading text-2xl font-extrabold leading-tight text-white drop-shadow sm:text-4xl">
                                    {{ $article->title }}
                                </h1>
                            </a>
                            <p class="mt-3 hidden max-w-2xl text-sm text-white/80 sm:block">{{ $article->excerpt }}</p>
                            <div class="mt-3 flex items-center gap-3 text-xs text-white/70">
                                <span>{{ $article->author->name ?? 'Redaksi' }}</span>
                                <span>&middot;</span>
                                <time>{{ $article->published_at?->diffForHumans() }}</time>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="absolute bottom-4 right-4 flex gap-1.5 sm:bottom-6 sm:right-8">
                    @foreach ($articles as $index => $article)
                        <button @click="active = {{ $index }}"
                            :class="active === {{ $index }} ? 'w-6 bg-accent' : 'w-2 bg-white/50'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
