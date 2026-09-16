@props(['variant' => 'neutral'])

@php
    $variants = [
        'success' => 'bg-success/10 text-success dark:bg-success/20',
        'pending' => 'bg-accent/20 text-primary-dark dark:text-accent',
        'danger' => 'bg-danger/10 text-danger dark:bg-danger/20',
        'breaking' => 'bg-danger text-white',
        'featured' => 'bg-accent text-primary-dark',
        'info' => 'bg-primary-light/10 text-primary-light dark:bg-primary-light/20',
        'neutral' => 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400',
    ][$variant] ?? 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold {$variants}"]) }}>
    {{ $slot }}
</span>
