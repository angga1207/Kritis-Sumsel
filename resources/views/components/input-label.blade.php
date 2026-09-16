@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400']) }}>
    {{ $value ?? $slot }}
</label>
