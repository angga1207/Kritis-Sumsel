<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin', ['title' => 'Manajemen Artikel'])]
class ArticleManager extends Component
{
    use AuthorizesRequests, WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $category = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function delete(Article $article): void
    {
        $this->authorize('articles.delete');
        $article->delete();
        $this->dispatch('toast', type: 'success', message: 'Artikel berhasil dihapus.');
    }

    public function render()
    {
        $query = Article::with(['author', 'category']);

        if (! Auth::user()->can('categories.manage')) {
            $query->where('user_id', Auth::id());
        }

        if ($this->search) {
            $query->where('title', 'ilike', "%{$this->search}%");
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        $articles = $query->latest()->paginate(15);

        return view('livewire.admin.article-manager', [
            'articles' => $articles,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
