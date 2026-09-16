@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-2.5 w-full ps-3 pe-4 py-2.5 border-l-4 border-primary text-start text-base font-semibold text-primary-dark bg-primary/5 focus:outline-none transition duration-150 ease-in-out'
            : 'flex items-center gap-2.5 w-full ps-3 pe-4 py-2.5 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-primary-dark hover:bg-secondary hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
