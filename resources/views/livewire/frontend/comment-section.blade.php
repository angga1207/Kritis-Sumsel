<div class="mx-auto max-w-3xl px-4 py-8">
    <x-section-title :title="'Komentar ('.$comments->count().')'" />

    <form wire:submit="submit" class="mb-8 space-y-3 rounded-lg bg-white p-4 shadow-sm ring-1 ring-black/5 dark:bg-gray-900 dark:shadow-none dark:ring-1 dark:ring-white/10">
        @guest
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <input type="text" wire:model="guestName" placeholder="Nama" class="rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <input type="email" wire:model="guestEmail" placeholder="Email" class="rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            @error('guestName') <p class="text-xs text-danger">{{ $message }}</p> @enderror
            @error('guestEmail') <p class="text-xs text-danger">{{ $message }}</p> @enderror
        @endguest

        <textarea wire:model="content" rows="3" placeholder="Tulis komentar Anda..."
            class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
        @error('content') <p class="text-xs text-danger">{{ $message }}</p> @enderror

        <button type="submit" wire:loading.attr="disabled" class="btn-primary">Kirim Komentar</button>
    </form>

    <div class="space-y-6">
        @forelse ($comments as $comment)
            <div class="rounded-lg bg-white p-4 shadow-sm ring-1 ring-black/5 dark:bg-gray-900 dark:shadow-none dark:ring-1 dark:ring-white/10">
                <div class="flex items-center gap-2 text-sm font-semibold text-primary-dark dark:text-white">
                    {{ $comment->author->name ?? $comment->name ?? 'Anonim' }}
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">&middot; {{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>

                <div class="mt-2 flex items-center gap-3">
                    <button wire:click="toggleLike({{ $comment->id }})"
                        class="flex items-center gap-1 text-xs font-semibold {{ $comment->likes->contains('user_id', auth()->id()) ? 'text-primary-light' : 'text-gray-500 hover:text-primary-light dark:text-gray-400' }}">
                        <x-dynamic-component :component="$comment->likes->contains('user_id', auth()->id()) ? 'heroicon-s-heart' : 'heroicon-o-heart'" class="h-3.5 w-3.5" />
                        {{ $comment->likes->count() }}
                    </button>
                    <button wire:click="startReply({{ $comment->id }})" class="text-xs font-semibold text-primary-light hover:underline">Balas</button>
                </div>

                @if ($replyTo === $comment->id)
                    <form wire:submit="submitReply({{ $comment->id }})" class="mt-3 space-y-2">
                        <textarea wire:model="replyContent" rows="2" placeholder="Tulis balasan..."
                            class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary"></textarea>
                        @error('replyContent') <p class="text-xs text-danger">{{ $message }}</p> @enderror
                        <div class="flex gap-2">
                            <button type="submit" class="btn-primary !px-3 !py-1.5 !text-xs">Kirim Balasan</button>
                            <button type="button" wire:click="cancelReply" class="btn-outline !px-3 !py-1.5 !text-xs">Batal</button>
                        </div>
                    </form>
                @endif

                @if ($comment->replies->isNotEmpty())
                    <div class="mt-4 space-y-3 border-l-2 border-secondary pl-4 dark:border-gray-700">
                        @foreach ($comment->replies as $reply)
                            <div>
                                <div class="flex items-center gap-2 text-sm font-semibold text-primary-dark dark:text-white">
                                    {{ $reply->author->name ?? 'Anonim' }}
                                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">&middot; {{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ $reply->content }}</p>
                                <button wire:click="toggleLike({{ $reply->id }})"
                                    class="mt-1 flex items-center gap-1 text-xs font-semibold {{ $reply->likes->contains('user_id', auth()->id()) ? 'text-primary-light' : 'text-gray-500 hover:text-primary-light dark:text-gray-400' }}">
                                    <x-dynamic-component :component="$reply->likes->contains('user_id', auth()->id()) ? 'heroicon-s-heart' : 'heroicon-o-heart'" class="h-3.5 w-3.5" />
                                    {{ $reply->likes->count() }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
        @endforelse
    </div>
</div>
