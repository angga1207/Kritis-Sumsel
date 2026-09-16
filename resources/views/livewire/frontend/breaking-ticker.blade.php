<div>
    @if ($articles->isNotEmpty())
        <div class="overflow-hidden border-b border-white/10 bg-danger">
            <div class="mx-auto flex max-w-7xl items-center gap-3 px-4 py-2">
                <span class="flex shrink-0 items-center gap-1 rounded bg-white px-2 py-1 text-xs font-extrabold uppercase tracking-wide text-danger">
                    <svg class="h-3 w-3 animate-pulse" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                    Breaking
                </span>
                <div class="relative flex-1 overflow-hidden" x-data>
                    <div class="flex animate-[marquee_25s_linear_infinite] gap-10 whitespace-nowrap text-sm font-medium text-white">
                        @foreach ($articles->concat($articles) as $article)
                            <a href="{{ route('article.show', $article->slug) }}" wire:navigate class="hover:text-accent">{{ $article->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <style>
            @keyframes marquee {
                from { transform: translateX(0); }
                to { transform: translateX(-50%); }
            }
        </style>
    @endif
</div>
