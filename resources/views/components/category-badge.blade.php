@props(['category'])

<a href="{{ route('category.show', $category->slug) }}" wire:navigate
    {{ $attributes->class(['category-badge']) }}
    style="background-color: {{ $category->color }}">
    {{ $category->name }}
</a>
