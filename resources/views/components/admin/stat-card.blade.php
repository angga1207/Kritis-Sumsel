@props([
    'icon' => 'chart-bar',
    'label',
    'value',
    'color' => 'primary',
    'trend' => null,
    'trendUp' => true,
    'delay' => 0,
])

@php
    $palette = [
        'primary' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'bar' => 'bg-primary'],
        'success' => ['bg' => 'bg-success/10', 'text' => 'text-success', 'bar' => 'bg-success'],
        'accent' => ['bg' => 'bg-accent/20', 'text' => 'text-primary-dark', 'bar' => 'bg-accent'],
        'danger' => ['bg' => 'bg-danger/10', 'text' => 'text-danger', 'bar' => 'bg-danger'],
        'info' => ['bg' => 'bg-primary-light/10', 'text' => 'text-primary-light', 'bar' => 'bg-primary-light'],
    ][$color] ?? ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'bar' => 'bg-primary'];
@endphp

<div
    data-aos="fade-up"
    data-aos-delay="{{ $delay }}"
    data-aos-duration="400"
    class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-sm ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:bg-gray-900 dark:shadow-none dark:ring-1 dark:ring-white/10 dark:hover:ring-accent/40"
>
    <div class="absolute inset-x-0 top-0 h-1 {{ $palette['bar'] }}"></div>
    <div class="flex items-start justify-between">
        <div class="min-w-0">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500">{{ $label }}</p>
            <p class="mt-1.5 font-heading text-2xl font-bold text-primary-dark tabular-nums dark:text-white">{{ $value }}</p>
            @if ($trend)
                <p class="mt-1.5 flex items-center gap-1 text-xs font-medium {{ $trendUp ? 'text-success' : 'text-danger' }}">
                    <x-dynamic-component :component="$trendUp ? 'heroicon-s-arrow-trending-up' : 'heroicon-s-arrow-trending-down'" class="h-3.5 w-3.5" />
                    {{ $trend }}
                </p>
            @endif
        </div>
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg {{ $palette['bg'] }} {{ $palette['text'] }} transition-transform duration-300 group-hover:scale-110">
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-5 w-5" />
        </span>
    </div>
</div>
