<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    public ?Category $category = null;

    #[Url]
    public string $tag = '';

    public int $perPage = 9;

    public function loadMore(): void
    {
        $this->perPage += 9;
    }

    public function updatedTag(): void
    {
        $this->perPage = 9;
    }

    public function getArticlesProperty()
    {
        $query = Article::published()->with(['category', 'author', 'tags']);

        if ($this->category) {
            $categoryIds = [$this->category->id, ...$this->category->children()->pluck('id')];
            $query->whereIn('category_id', $categoryIds);
        }

        if ($this->tag) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $this->tag));
        }

        return $query->latest('published_at')->paginate($this->perPage, pageName: 'noop');
    }

    public function getTagsProperty()
    {
        return Tag::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.frontend.article-list', [
            'articles' => $this->articles,
            'tags' => $this->tags,
        ]);
    }
}
