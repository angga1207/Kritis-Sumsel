<div>
    @if ($articles->isNotEmpty())
        <section class="relative bg-gradient-to-br from-primary-dark via-primary to-primary-light" x-data="{ active: 0, count: {{ $articles->count() }} }"
            x-init="setInterval(() => active = (active + 1) % count, 6000)">
            <div class="relative mx-auto max-w-7xl">
                @foreach ($articles as $index => $article)
                    <div x-show="active === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 scale-[1.02]" x-transition:enter-end="opacity-100 scale-100" x-cloak
                        class="relative aspect-[4/5] w-full overflow-hidden sm:aspect-[21/9]">
                        <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                            class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-10">
                            @if ($article->category)
                                <x-category-badge :category="$article->category" class="mb-3 animate-float-up" />
                            @endif
                            <a href="{{ route('article.show', $article->slug) }}" wire:navigate class="group">
                                <h1 class="max-w-3xl font-heading text-2xl font-extrabold leading-tight text-white drop-shadow sm:text-4xl">
                                    <span class="bg-gradient-to-r from-accent to-accent bg-[length:0%_2px] bg-left-bottom bg-no-repeat transition-[background-size] duration-500 group-hover:bg-[length:100%_2px]">
                                        {{ $article->title }}
                                    </span>
                                </h1>
                            </a>
                            <p class="mt-3 hidden max-w-2xl text-sm text-white/80 sm:block">{{ $article->excerpt }}</p>
                            <div class="mt-3 flex items-center gap-3 text-xs text-white/70">
                                <span class="flex items-center gap-1"><x-heroicon-o-user class="h-3.5 w-3.5" /> {{ $article->author->name ?? 'Redaksi' }}</span>
                                <span class="flex items-center gap-1"><x-heroicon-o-clock class="h-3.5 w-3.5" /> {{ $article->published_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <button @click="active = (active - 1 + count) % count" aria-label="Sebelumnya"
                    class="absolute left-3 top-1/2 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-white backdrop-blur transition hover:bg-white/30 sm:flex">
                    <x-heroicon-o-chevron-left class="h-5 w-5" />
                </button>
                <button @click="active = (active + 1) % count" aria-label="Berikutnya"
                    class="absolute right-3 top-1/2 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/15 text-white backdrop-blur transition hover:bg-white/30 sm:flex">
                    <x-heroicon-o-chevron-right class="h-5 w-5" />
                </button>

                <div class="absolute bottom-4 right-4 flex gap-1.5 sm:bottom-6 sm:right-8">
                    @foreach ($articles as $index => $article)
                        <button @click="active = {{ $index }}" aria-label="Slide {{ $index + 1 }}"
                            :class="active === {{ $index }} ? 'w-6 bg-accent' : 'w-2 bg-white/50 hover:bg-white/80'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
