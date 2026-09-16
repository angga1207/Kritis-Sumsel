<div class="space-y-6">
    <x-admin.page-header title="Analitik" subtitle="Pantau performa konten dan trafik pembaca." icon="chart-bar" />

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-admin.stat-card icon="eye" label="Total Views Sepanjang Waktu" :value="number_format($totalViews)" color="primary" :delay="0" />
        <x-admin.stat-card icon="calendar-days" label="Views 14 Hari Terakhir" :value="number_format($viewsLast14Days)" color="accent" :delay="50" />
    </div>

    <x-admin.card title="Views 14 Hari Terakhir" icon="chart-bar" :delay="100">
        <div wire:ignore x-data="viewsChart(@js($chartLabels), @js($chartData))" class="relative w-full" style="height: 260px;">
            <canvas x-ref="canvas"></canvas>
        </div>
    </x-admin.card>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-admin.card title="Artikel Terpopuler" icon="fire" no-padding :delay="150">
            @forelse ($topArticles as $index => $article)
                <div class="flex items-center gap-3 border-b border-secondary px-5 py-3 transition hover:bg-secondary/20 last:border-0">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary text-xs font-bold text-gray-500">{{ $index + 1 }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-medium text-primary-dark">{{ Str::limit($article->title, 45) }}</p>
                        <p class="text-xs text-gray-400">{{ $article->category->name ?? '-' }}</p>
                    </div>
                    <span class="shrink-0 font-semibold text-primary-dark tabular-nums">{{ number_format($article->views_count) }}</span>
                </div>
            @empty
                <x-admin.empty-state icon="fire" title="Belum ada data" />
            @endforelse
        </x-admin.card>

        <x-admin.card title="Views per Kategori" icon="squares-2x2" no-padding :delay="150">
            @forelse ($topCategories as $category)
                <div class="flex items-center justify-between border-b border-secondary px-5 py-3 transition hover:bg-secondary/20 last:border-0">
                    <span class="inline-flex items-center gap-2 font-medium text-primary-dark">
                        <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $category->color }}"></span>
                        {{ $category->name }}
                    </span>
                    <span class="font-semibold text-primary-dark tabular-nums">{{ number_format($category->articles_sum_views_count ?? 0) }}</span>
                </div>
            @empty
                <x-admin.empty-state icon="squares-2x2" title="Belum ada data" />
            @endforelse
        </x-admin.card>
    </div>
</div>
