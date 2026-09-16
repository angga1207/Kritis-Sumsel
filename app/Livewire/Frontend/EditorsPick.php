<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use Livewire\Component;

class EditorsPick extends Component
{
    public function render()
    {
        $articles = Article::published()
            ->with(['category', 'author'])
            ->whereHas('author.roles', fn ($q) => $q->whereIn('name', ['editor', 'super_admin']))
            ->latest('published_at')
            ->take(6)
            ->get();

        if ($articles->count() < 3) {
            $articles = Article::published()
                ->with(['category', 'author'])
                ->trending()
                ->take(6)
                ->get();
        }

        return view('livewire.frontend.editors-pick', ['articles' => $articles]);
    }
}
