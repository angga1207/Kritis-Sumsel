<div class="space-y-6">
    <x-admin.page-header title="Artikel" subtitle="Kelola seluruh artikel yang dipublikasikan." icon="document-text">
        <x-slot:actions>
            <a href="{{ route('admin.articles.create') }}" wire:navigate class="btn-primary">
                <x-heroicon-o-plus class="h-4 w-4" />
                Tulis Artikel
            </a>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card no-padding>
        <div class="flex flex-col gap-3 border-b border-secondary p-4 dark:border-gray-800 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <x-heroicon-o-magnifying-glass class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" />
                <input type="text" wire:model.live.debounce.400ms="search" placeholder="Cari judul artikel..."
                    class="w-full rounded-lg border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
            </div>
            <div class="relative">
                <x-heroicon-o-flag class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" />
                <select wire:model.live="status" class="rounded-lg border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="pending">Pending</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="relative">
                <x-heroicon-o-tag class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" />
                <select wire:model.live="category" class="rounded-lg border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Desktop table --}}
        <div class="hidden overflow-x-auto lg:block">
            <table class="w-full text-left text-sm">
                <thead class="bg-secondary/40 text-xs uppercase text-gray-500 dark:bg-white/5 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3">Artikel</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Views</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary dark:divide-gray-800">
                    @forelse ($articles as $article)
                        <tr wire:key="article-{{ $article->id }}" class="transition hover:bg-secondary/20 dark:hover:bg-white/5">
                            <td class="max-w-sm px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-16 shrink-0 overflow-hidden rounded-md bg-secondary dark:bg-gray-800">
                                        @if ($article->featured_image)
                                            <img src="{{ $article->featured_image }}" alt="" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-gray-300 dark:text-gray-600">
                                                <x-heroicon-o-photo class="h-5 w-5" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @if ($article->is_breaking)<x-admin.badge variant="breaking">BREAKING</x-admin.badge>@endif
                                            @if ($article->is_featured)<x-admin.badge variant="featured">FEATURED</x-admin.badge>@endif
                                        </div>
                                        <p class="truncate font-medium text-primary-dark dark:text-white" title="{{ $article->title }}">{{ $article->title }}</p>
                                        <p class="flex items-center gap-1 truncate text-xs text-gray-400 dark:text-gray-500">
                                            <x-heroicon-o-user class="h-3 w-3 shrink-0" /> {{ $article->author->name ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                @if ($article->category)
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-medium text-white" style="background-color: {{ $article->category->color }}">
                                        {{ $article->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <x-admin.badge :variant="match($article->status) {
                                    'published' => 'success',
                                    'pending' => 'pending',
                                    'archived' => 'neutral',
                                    default => 'neutral',
                                }">
                                    <x-dynamic-component :component="'heroicon-s-' . match($article->status) {
                                        'published' => 'check-circle',
                                        'pending' => 'clock',
                                        'archived' => 'archive-box',
                                        default => 'pencil',
                                    }" class="h-3 w-3" />
                                    {{ ucfirst($article->status) }}
                                </x-admin.badge>
                            </td>
                            <td class="px-5 py-3 text-gray-500 dark:text-gray-400">
                                <span class="flex items-center gap-1"><x-heroicon-o-eye class="h-3.5 w-3.5" /> {{ number_format($article->views_count) }}</span>
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">
                                {{ ($article->published_at ?? $article->created_at)?->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('article.show', $article->slug) }}" target="_blank"
                                        class="rounded-lg p-1.5 text-gray-400 transition hover:bg-secondary hover:text-primary dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-accent" title="Lihat">
                                        <x-heroicon-o-eye class="h-4 w-4" />
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $article) }}" wire:navigate
                                        class="rounded-lg p-1.5 text-primary-light transition hover:bg-primary/10 dark:hover:bg-primary-light/10" title="Edit">
                                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                                    </a>
                                    <button type="button" x-data
                                        x-on:click="if (await confirmDelete('Artikel ini akan dihapus permanen.')) $wire.delete({{ $article->id }})"
                                        class="rounded-lg p-1.5 text-danger transition hover:bg-danger/10" title="Hapus">
                                        <x-heroicon-o-trash class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><x-admin.empty-state icon="document-text" title="Belum ada artikel" description="Mulai dengan menulis artikel pertama Anda." /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="divide-y divide-secondary p-2 dark:divide-gray-800 lg:hidden">
            @forelse ($articles as $article)
                <div wire:key="article-m-{{ $article->id }}" class="flex gap-3 p-3">
                    <div class="h-16 w-20 shrink-0 overflow-hidden rounded-md bg-secondary dark:bg-gray-800">
                        @if ($article->featured_image)
                            <img src="{{ $article->featured_image }}" alt="" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-gray-300 dark:text-gray-600">
                                <x-heroicon-o-photo class="h-5 w-5" />
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-1.5">
                            @if ($article->is_breaking)<x-admin.badge variant="breaking">BREAKING</x-admin.badge>@endif
                            @if ($article->is_featured)<x-admin.badge variant="featured">FEATURED</x-admin.badge>@endif
                            <x-admin.badge :variant="match($article->status) {
                                'published' => 'success',
                                'pending' => 'pending',
                                'archived' => 'neutral',
                                default => 'neutral',
                            }">{{ ucfirst($article->status) }}</x-admin.badge>
                        </div>
                        <p class="mt-1 truncate font-medium text-primary-dark dark:text-white">{{ $article->title }}</p>
                        <p class="mt-0.5 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-400 dark:text-gray-500">
                            <span class="flex items-center gap-1"><x-heroicon-o-user class="h-3 w-3" /> {{ $article->author->name ?? '-' }}</span>
                            <span class="flex items-center gap-1"><x-heroicon-o-eye class="h-3 w-3" /> {{ number_format($article->views_count) }}</span>
                            <span>{{ ($article->published_at ?? $article->created_at)?->translatedFormat('d M Y') }}</span>
                        </p>
                        <div class="mt-2 flex items-center gap-1">
                            <a href="{{ route('admin.articles.edit', $article) }}" wire:navigate
                                class="rounded-lg p-1.5 text-primary-light transition hover:bg-primary/10 dark:hover:bg-primary-light/10" title="Edit">
                                <x-heroicon-o-pencil-square class="h-4 w-4" />
                            </a>
                            <button type="button" x-data
                                x-on:click="if (await confirmDelete('Artikel ini akan dihapus permanen.')) $wire.delete({{ $article->id }})"
                                class="rounded-lg p-1.5 text-danger transition hover:bg-danger/10" title="Hapus">
                                <x-heroicon-o-trash class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <x-admin.empty-state icon="document-text" title="Belum ada artikel" description="Mulai dengan menulis artikel pertama Anda." />
            @endforelse
        </div>
    </x-admin.card>

    <div>{{ $articles->links() }}</div>
</div>
