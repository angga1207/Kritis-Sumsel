<div class="space-y-6">
    <x-admin.page-header title="Komentar" subtitle="Moderasi komentar yang masuk dari pembaca." icon="chat-bubble-left-right" />

    <div class="flex flex-wrap gap-2">
        @foreach (['pending' => 'Pending', 'approved' => 'Disetujui', 'spam' => 'Spam', 'all' => 'Semua'] as $value => $label)
            <button wire:click="$set('filter', '{{ $value }}')"
                class="rounded-full px-3.5 py-1.5 text-xs font-semibold transition {{ $filter === $value ? 'bg-primary text-white shadow-sm' : 'bg-white text-gray-600 ring-1 ring-black/5 hover:bg-secondary' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="space-y-3">
        @forelse ($comments as $comment)
            <div wire:key="comment-{{ $comment->id }}" data-aos="fade-up" data-aos-duration="300"
                class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-black/5 transition hover:shadow-md">
                <div class="flex items-start gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                        {{ mb_substr($comment->author->name ?? $comment->name ?? 'A', 0, 1) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <p class="text-sm font-semibold text-primary-dark">{{ $comment->author->name ?? $comment->name ?? 'Anonim' }}</p>
                            <x-admin.badge :variant="match($comment->status) { 'approved' => 'success', 'spam' => 'danger', default => 'pending' }">
                                {{ ucfirst($comment->status) }}
                            </x-admin.badge>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">{{ $comment->content }}</p>
                        <a href="{{ route('article.show', $comment->article->slug) }}" target="_blank" class="mt-2 inline-flex items-center gap-1 text-xs text-primary-light hover:underline">
                            <x-heroicon-o-arrow-top-right-on-square class="h-3 w-3" />
                            pada: {{ Str::limit($comment->article->title, 60) }}
                        </a>

                        <div class="mt-3 flex flex-wrap gap-2">
                            @if ($comment->status !== 'approved')
                                <button wire:click="approve({{ $comment->id }})" class="flex items-center gap-1 rounded-md bg-success/10 px-2.5 py-1 text-xs font-semibold text-success transition hover:bg-success/20">
                                    <x-heroicon-o-check class="h-3.5 w-3.5" />
                                    Setujui
                                </button>
                            @endif
                            @if ($comment->status !== 'spam')
                                <button wire:click="markSpam({{ $comment->id }})" class="flex items-center gap-1 rounded-md bg-accent/20 px-2.5 py-1 text-xs font-semibold text-primary-dark transition hover:bg-accent/30">
                                    <x-heroicon-o-no-symbol class="h-3.5 w-3.5" />
                                    Spam
                                </button>
                            @endif
                            <button type="button" x-data
                                x-on:click="if (await confirmDelete()) $wire.delete({{ $comment->id }})"
                                class="flex items-center gap-1 rounded-md bg-danger/10 px-2.5 py-1 text-xs font-semibold text-danger transition hover:bg-danger/20">
                                <x-heroicon-o-trash class="h-3.5 w-3.5" />
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <x-admin.card>
                <x-admin.empty-state icon="chat-bubble-left-right" title="Tidak ada komentar" description="Semua komentar pada filter ini sudah ditangani." />
            </x-admin.card>
        @endforelse
    </div>

    <div>{{ $comments->links() }}</div>
</div>
