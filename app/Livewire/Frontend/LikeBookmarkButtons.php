<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeBookmarkButtons extends Component
{
    public Article $article;

    public bool $liked = false;

    public bool $bookmarked = false;

    public int $likesCount = 0;

    public function mount(): void
    {
        $this->likesCount = $this->article->likes()->where('type', Like::TYPE_LIKE)->count();

        if (Auth::check()) {
            $this->liked = $this->article->likes()->where('user_id', Auth::id())->where('type', Like::TYPE_LIKE)->exists();
            $this->bookmarked = $this->article->likes()->where('user_id', Auth::id())->where('type', Like::TYPE_BOOKMARK)->exists();
        }
    }

    public function toggleLike(): void
    {
        if (! Auth::check()) {
            $this->dispatch('toast', type: 'error', message: 'Silakan masuk untuk menyukai artikel.');

            return;
        }

        $existing = $this->article->likes()->where('user_id', Auth::id())->where('type', Like::TYPE_LIKE)->first();

        if ($existing) {
            $existing->delete();
            $this->liked = false;
            $this->likesCount--;
        } else {
            $this->article->likes()->create(['user_id' => Auth::id(), 'type' => Like::TYPE_LIKE]);
            $this->liked = true;
            $this->likesCount++;
        }
    }

    public function toggleBookmark(): void
    {
        if (! Auth::check()) {
            $this->dispatch('toast', type: 'error', message: 'Silakan masuk untuk menyimpan artikel.');

            return;
        }

        $existing = $this->article->likes()->where('user_id', Auth::id())->where('type', Like::TYPE_BOOKMARK)->first();

        if ($existing) {
            $existing->delete();
            $this->bookmarked = false;
        } else {
            $this->article->likes()->create(['user_id' => Auth::id(), 'type' => Like::TYPE_BOOKMARK]);
            $this->bookmarked = true;
            $this->dispatch('toast', type: 'success', message: 'Artikel disimpan ke bookmark.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.like-bookmark-buttons');
    }
}
