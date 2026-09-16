@props(['title', 'link' => null])

<div class="section-title" data-aos="fade-up">
    <span>{{ $title }}</span>
    @if ($link)
        <a href="{{ $link }}" wire:navigate class="group ml-2 flex shrink-0 items-center gap-1 rounded-full bg-primary/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-primary transition hover:bg-primary hover:text-white dark:bg-white/10 dark:text-accent dark:hover:bg-accent dark:hover:text-primary-dark">
            Lihat semua
            <x-heroicon-o-arrow-right class="h-3 w-3 transition-transform duration-200 group-hover:translate-x-0.5" />
        </a>
    @endif
</div>
