@props(['title' => null, 'icon' => null, 'subtitle' => null, 'noPadding' => false, 'aos' => 'fade-up', 'delay' => 0])

<div {{ $attributes->merge(['class' => 'rounded-xl bg-white shadow-sm ring-1 ring-black/5 dark:bg-gray-900 dark:shadow-none dark:ring-1 dark:ring-white/10']) }}
    @if ($aos) data-aos="{{ $aos }}" data-aos-duration="400" data-aos-delay="{{ $delay }}" @endif>
    @if ($title || isset($actions))
        <div class="flex items-center justify-between gap-3 border-b border-secondary px-5 py-4 dark:border-gray-800">
            <div class="flex items-center gap-2.5">
                @if ($icon)
                    <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-5 w-5 text-primary dark:text-accent" />
                @endif
                <div>
                    <h3 class="font-heading text-base font-bold text-primary-dark dark:text-white">{{ $title }}</h3>
                    @if ($subtitle)
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @isset($actions)
                <div class="shrink-0">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div class="{{ $noPadding ? '' : 'p-5' }}">
        {{ $slot }}
    </div>
</div>
