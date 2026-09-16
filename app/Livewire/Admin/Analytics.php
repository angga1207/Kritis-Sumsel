<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin', ['title' => 'Analitik'])]
class Analytics extends Component
{
    use AuthorizesRequests;

    public function mount(): void
    {
        $this->authorize('articles.viewAny');
    }

    public function render()
    {
        $since = Carbon::now()->subDays(13)->startOfDay();

        $dailyViews = ArticleView::query()
            ->selectRaw('DATE(viewed_at) as day, COUNT(*) as total')
            ->where('viewed_at', '>=', $since)
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        $chartLabels = [];
        $chartData = [];

        for ($i = 0; $i < 14; $i++) {
            $date = $since->copy()->addDays($i);
            $key = $date->format('Y-m-d');
            $chartLabels[] = $date->translatedFormat('d M');
            $chartData[] = (int) ($dailyViews[$key] ?? 0);
        }

        $topArticles = Article::query()
            ->with(['category'])
            ->orderByDesc('views_count')
            ->take(10)
            ->get();

        $topCategories = Category::query()
            ->withSum('articles', 'views_count')
            ->orderByDesc('articles_sum_views_count')
            ->take(8)
            ->get();

        return view('livewire.admin.analytics', [
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'topArticles' => $topArticles,
            'topCategories' => $topCategories,
            'totalViews' => (int) Article::sum('views_count'),
            'viewsLast14Days' => array_sum($chartData),
        ]);
    }
}
