<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchArticles extends Component
{
    #[Url(as: 'q')]
    public string $query = '';

    #[Url(as: 'kategori')]
    public string $categorySlug = '';

    public int $perPage = 10;

    public function updatedQuery(): void
    {
        $this->perPage = 10;
    }

    public function updatedCategorySlug(): void
    {
        $this->perPage = 10;
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function getResultsProperty()
    {
        if (trim($this->query) === '') {
            return Article::published()->whereRaw('1=0')->paginate($this->perPage, pageName: 'noop');
        }

        $query = Article::published()->with(['category', 'author'])
            ->where(function ($q) {
                $q->where('title', 'ilike', "%{$this->query}%")
                    ->orWhere('excerpt', 'ilike', "%{$this->query}%");
            });

        if ($this->categorySlug) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->categorySlug));
        }

        return $query->latest('published_at')->paginate($this->perPage, pageName: 'noop');
    }

    public function render()
    {
        return view('livewire.frontend.search-articles', [
            'results' => $this->results,
            'categories' => Category::active()->orderBy('name')->get(),
        ]);
    }
}
