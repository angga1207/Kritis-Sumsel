<div class="flex items-center gap-3">
    <button wire:click="toggleLike" class="flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-medium transition active:scale-95 {{ $liked ? 'bg-danger/10 text-danger' : 'bg-secondary text-gray-600 hover:bg-secondary/70 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        <x-dynamic-component :component="$liked ? 'heroicon-s-heart' : 'heroicon-o-heart'" class="h-4 w-4" />
        {{ $likesCount }}
    </button>

    <button wire:click="toggleBookmark" class="flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-medium transition active:scale-95 {{ $bookmarked ? 'bg-accent/20 text-primary-dark dark:text-accent' : 'bg-secondary text-gray-600 hover:bg-secondary/70 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        <x-dynamic-component :component="$bookmarked ? 'heroicon-s-bookmark' : 'heroicon-o-bookmark'" class="h-4 w-4" />
        Simpan
    </button>
</div>
