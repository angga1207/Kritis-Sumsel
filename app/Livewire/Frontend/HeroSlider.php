<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use Livewire\Component;

class HeroSlider extends Component
{
    public int $active = 0;

    public function render()
    {
        $articles = Article::published()
            ->featured()
            ->with('category')
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('livewire.frontend.hero-slider', ['articles' => $articles]);
    }
}
