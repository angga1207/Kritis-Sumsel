<?php

namespace App\Livewire\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Models\Media;
use App\Models\Tag;
use App\Services\ImageUploadService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mews\Purifier\Facades\Purifier;

#[Layout('components.layouts.admin', ['title' => 'Form Artikel'])]
class ArticleForm extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public ?Article $article = null;

    public string $title = '';

    public string $excerpt = '';

    public string $content = '';

    public ?int $categoryId = null;

    public array $selectedTags = [];

    public $featuredImageUpload = null;

    public ?string $existingImage = null;

    public bool $isFeatured = false;

    public bool $isBreaking = false;

    public string $metaTitle = '';

    public string $metaDescription = '';

    public array $galleryUploads = [];

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:20',
            'categoryId' => 'required|exists:categories,id',
            'selectedTags' => 'array',
            'featuredImageUpload' => 'nullable|image|max:4096',
            'metaTitle' => 'nullable|string|max:255',
            'metaDescription' => 'nullable|string|max:255',
        ];
    }

    public function mount(?Article $article = null): void
    {
        $this->authorize($article?->exists ? 'articles.update' : 'articles.create');

        if ($article?->exists) {
            if (! Auth::user()->can('categories.manage') && $article->user_id !== Auth::id()) {
                abort(403);
            }

            $this->article = $article;
            $this->title = $article->title;
            $this->excerpt = (string) $article->excerpt;
            $this->content = $article->content;
            $this->categoryId = $article->category_id;
            $this->selectedTags = $article->tags->pluck('id')->map(fn ($id) => (string) $id)->all();
            $this->existingImage = $article->featured_image;
            $this->isFeatured = $article->is_featured;
            $this->isBreaking = $article->is_breaking;
            $this->metaTitle = (string) $article->meta_title;
            $this->metaDescription = (string) $article->meta_description;
        }
    }

    public function save(string $status): void
    {
        $this->validate();

        $imagePath = $this->existingImage;

        if ($this->featuredImageUpload) {
            $imagePath = app(ImageUploadService::class)->storeArticleImage($this->featuredImageUpload);
        }

        $data = [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => Purifier::clean($this->content),
            'category_id' => $this->categoryId,
            'featured_image' => $imagePath,
            'is_featured' => $this->isFeatured,
            'is_breaking' => $this->isBreaking,
            'meta_title' => $this->metaTitle ?: $this->title,
            'meta_description' => $this->metaDescription ?: $this->excerpt,
            'status' => $status,
            'published_at' => $status === 'published' ? ($this->article?->published_at ?? now()) : $this->article?->published_at,
        ];

        if ($this->article) {
            $this->authorize('articles.update');
            $this->article->update($data);
        } else {
            $data['user_id'] = Auth::id();
            $this->article = Article::create($data);
        }

        $this->article->tags()->sync($this->selectedTags);

        $this->dispatch('toast', type: 'success', message: 'Artikel berhasil disimpan.');
        $this->redirectRoute('admin.articles.index', navigate: true);
    }

    public function uploadGallery(): void
    {
        if (! $this->article) {
            return;
        }

        $this->validate([
            'galleryUploads.*' => 'image|max:4096',
        ]);

        $nextOrder = (int) $this->article->media()->max('order') + 1;

        foreach ($this->galleryUploads as $upload) {
            $path = app(ImageUploadService::class)->storeArticleImage($upload);

            $this->article->media()->create([
                'path' => $path,
                'type' => 'image',
                'order' => $nextOrder++,
            ]);
        }

        $this->reset('galleryUploads');
        $this->dispatch('toast', type: 'success', message: 'Gambar galeri berhasil diunggah.');
    }

    public function deleteMedia(Media $media): void
    {
        if (! $this->article || $media->article_id !== $this->article->id) {
            return;
        }

        $path = str_replace('/storage/', '', $media->path);
        Storage::disk('public')->delete($path);
        $media->delete();

        $this->dispatch('toast', type: 'success', message: 'Gambar galeri dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.article-form', [
            'categories' => Category::active()->orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'mediaItems' => $this->article?->media()->orderBy('order')->get() ?? collect(),
        ]);
    }
}
