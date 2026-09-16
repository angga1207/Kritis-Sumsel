<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin', ['title' => 'Ringkasan'])]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'total_views' => Article::sum('views_count'),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'total_users' => User::count(),
        ];

        $recentArticles = Article::with(['author', 'category'])->latest()->take(8)->get();

        $since = Carbon::now()->subDays(6)->startOfDay();
        $dailyViews = ArticleView::query()
            ->selectRaw('DATE(viewed_at) as day, COUNT(*) as total')
            ->where('viewed_at', '>=', $since)
            ->groupBy('day')
            ->pluck('total', 'day');

        $chartLabels = [];
        $chartData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $since->copy()->addDays($i);
            $chartLabels[] = $date->translatedFormat('d M');
            $chartData[] = (int) ($dailyViews[$date->format('Y-m-d')] ?? 0);
        }

        return view('livewire.admin.dashboard', compact('stats', 'recentArticles', 'chartLabels', 'chartData'));
    }
}
