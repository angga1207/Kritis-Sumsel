<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Tag;
use Livewire\Component;

class TrendingSidebar extends Component
{
    public function render()
    {
        $trending = Article::published()->trending()->take(5)->get(['id', 'title', 'slug', 'views_count', 'published_at']);
        $tags = Tag::orderBy('name')->take(20)->get();

        return view('livewire.frontend.trending-sidebar', compact('trending', 'tags'));
    }
}
