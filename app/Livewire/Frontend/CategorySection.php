<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;

class CategorySection extends Component
{
    public Category $category;

    public function render()
    {
        $articles = Article::published()
            ->where('category_id', $this->category->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(7)
            ->get();

        return view('livewire.frontend.category-section', [
            'main' => $articles->first(),
            'rest' => $articles->slice(1),
        ]);
    }
}
