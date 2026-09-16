@props(['title', 'link' => null])

<div class="section-title" data-aos="fade-up">
    <span>{{ $title }}</span>
    @if ($link)
        <a href="{{ $link }}" wire:navigate class="ml-2 shrink-0 text-xs font-semibold uppercase tracking-wide text-primary-light hover:text-accent">
            Lihat semua &rarr;
        </a>
    @endif
</div>
