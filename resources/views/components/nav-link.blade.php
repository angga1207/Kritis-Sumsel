@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-1.5 px-1 pt-1 border-b-2 border-primary text-sm font-semibold leading-5 text-primary-dark focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center gap-1.5 px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-primary-dark hover:border-gray-300 focus:outline-none focus:text-primary-dark focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
