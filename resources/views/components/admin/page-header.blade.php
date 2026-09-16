@props(['title', 'subtitle' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }} data-aos="fade-down" data-aos-duration="400">
    <div class="flex items-center gap-3">
        @if ($icon)
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary dark:bg-white/10 dark:text-accent">
                <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-6 w-6" />
            </span>
        @endif
        <div>
            <h1 class="font-heading text-xl font-bold text-primary-dark sm:text-2xl dark:text-white">{{ $title }}</h1>
            @if ($subtitle)
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @isset($actions)
        <div class="flex shrink-0 flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
