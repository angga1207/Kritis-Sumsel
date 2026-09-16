<x-layouts.public :title="$category->name.' — Kritis Sumsel'" :description="$category->description">
    <div class="border-b border-secondary bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 py-8">
            @if ($category->parent)
                <nav class="mb-3 text-xs text-gray-500 dark:text-gray-400">
                    <a href="{{ route('category.show', $category->parent->slug) }}" wire:navigate class="hover:text-primary dark:hover:text-accent">{{ $category->parent->name }}</a>
                    <span class="mx-1">/</span>
                    <span class="text-gray-600 dark:text-gray-300">{{ $category->name }}</span>
                </nav>
            @endif

            <span class="category-badge" style="background-color: {{ $category->color }}">{{ $category->name }}</span>
            <h1 class="mt-3 flex items-center gap-2 font-heading text-3xl font-extrabold text-primary-dark dark:text-white">
                <x-heroicon-s-newspaper class="h-7 w-7 text-primary-light dark:text-accent" />{{ $category->name }}
            </h1>
            @if ($category->description)
                <p class="mt-2 max-w-2xl text-sm text-gray-500 dark:text-gray-400">{{ $category->description }}</p>
            @endif

            @if ($category->children->isNotEmpty())
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($category->children as $child)
                        <a href="{{ route('category.show', $child->slug) }}" wire:navigate
                            class="rounded-full bg-secondary px-3 py-1 text-xs font-medium text-primary-dark hover:bg-primary hover:text-white dark:bg-gray-800 dark:text-gray-200">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <livewire:frontend.article-list :category="$category" />
            </div>
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-24">
                    <livewire:frontend.trending-sidebar />
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>
