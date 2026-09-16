@props(['icon' => 'inbox', 'title' => 'Belum ada data', 'description' => null])

<div class="flex flex-col items-center justify-center py-14 text-center">
    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-secondary text-gray-400 dark:bg-gray-800 dark:text-gray-500">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-7 w-7" />
    </span>
    <p class="mt-4 text-sm font-semibold text-gray-600 dark:text-gray-300">{{ $title }}</p>
    @if ($description)
        <p class="mt-1 max-w-xs text-xs text-gray-400 dark:text-gray-500">{{ $description }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
