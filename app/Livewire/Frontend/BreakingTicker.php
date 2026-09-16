<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class BreakingTicker extends Component
{
    public function render()
    {
        $articles = Article::published()->breaking()->latest('published_at')->take(6)->get(['id', 'title', 'slug']);

        return view('livewire.frontend.breaking-ticker', ['articles' => $articles]);
    }
}
