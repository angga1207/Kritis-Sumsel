<div class="space-y-6">
    <x-admin.page-header title="Ringkasan" subtitle="Selamat datang kembali, {{ auth()->user()->name }}." icon="squares-2x2" />

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <x-admin.stat-card icon="document-text" label="Total Artikel" :value="$stats['total_articles']" color="primary" :delay="0" />
        <x-admin.stat-card icon="check-circle" label="Dipublikasi" :value="$stats['published_articles']" color="success" :delay="50" />
        <x-admin.stat-card icon="eye" label="Total Views" :value="number_format($stats['total_views'])" color="accent" :delay="100" />
        <x-admin.stat-card icon="chat-bubble-left-right" label="Komentar Pending" :value="$stats['pending_comments']" color="danger" :delay="150" />
        <x-admin.stat-card icon="users" label="Total Pengguna" :value="$stats['total_users']" color="info" :delay="200" />
    </div>

    <x-admin.card title="Views 7 Hari Terakhir" icon="chart-bar">
        <x-slot:actions>
            <a href="{{ route('admin.analytics.index') }}" wire:navigate class="flex items-center gap-1 text-xs font-semibold text-primary-light hover:underline">
                Lihat Analitik Lengkap
                <x-heroicon-s-arrow-right class="h-3.5 w-3.5" />
            </a>
        </x-slot:actions>
        <div wire:ignore x-data="viewsChart(@js($chartLabels), @js($chartData))" class="relative w-full" style="height: 200px;">
            <canvas x-ref="canvas"></canvas>
        </div>
    </x-admin.card>

    <x-admin.card title="Artikel Terbaru" icon="document-text" no-padding :delay="100">
        @forelse ($recentArticles as $article)
            <div wire:key="recent-{{ $article->id }}"
                class="flex flex-col gap-2 border-b border-secondary px-5 py-3 transition hover:bg-secondary/30 last:border-0 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <a href="{{ route('admin.articles.edit', $article) }}" wire:navigate
                        class="font-medium text-primary-dark hover:text-primary-light">{{ Str::limit($article->title, 55) }}</a>
                    <p class="mt-0.5 text-xs text-gray-400">{{ $article->author->name ?? '-' }} &middot; {{ $article->category->name ?? '-' }}</p>
                </div>
                <div class="flex shrink-0 items-center gap-3">
                    <span class="flex items-center gap-1 text-xs text-gray-400">
                        <x-heroicon-o-eye class="h-3.5 w-3.5" />
                        {{ number_format($article->views_count) }}
                    </span>
                    <x-admin.badge :variant="match($article->status) {
                        'published' => 'success',
                        'pending' => 'pending',
                        'archived' => 'neutral',
                        default => 'neutral',
                    }">{{ ucfirst($article->status) }}</x-admin.badge>
                </div>
            </div>
        @empty
            <x-admin.empty-state icon="document-text" title="Belum ada artikel" />
        @endforelse
    </x-admin.card>
</div>
