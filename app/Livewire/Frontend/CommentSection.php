<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentSection extends Component
{
    public Article $article;

    public string $content = '';

    public string $guestName = '';

    public string $guestEmail = '';

    public ?int $replyTo = null;

    public string $replyContent = '';

    protected function rules(): array
    {
        $rules = ['content' => 'required|string|min:3|max:2000'];

        if (! Auth::check()) {
            $rules['guestName'] = 'required|string|max:255';
            $rules['guestEmail'] = 'required|email|max:255';
        }

        return $rules;
    }

    public function submit(): void
    {
        $this->validate();

        $this->article->comments()->create([
            'user_id' => Auth::id(),
            'name' => Auth::check() ? null : $this->guestName,
            'email' => Auth::check() ? null : $this->guestEmail,
            'content' => $this->content,
            'status' => Auth::check() ? 'approved' : 'pending',
        ]);

        $this->reset('content', 'guestName', 'guestEmail');
        $this->dispatch('toast', type: 'success', message: 'Komentar terkirim, menunggu moderasi.');
    }

    public function startReply(int $commentId): void
    {
        $this->replyTo = $commentId;
        $this->replyContent = '';
    }

    public function cancelReply(): void
    {
        $this->replyTo = null;
    }

    public function submitReply(int $parentId): void
    {
        $this->validate(['replyContent' => 'required|string|min:3|max:2000']);

        if (! Auth::check()) {
            $this->dispatch('toast', type: 'error', message: 'Silakan masuk untuk membalas komentar.');

            return;
        }

        $this->article->comments()->create([
            'user_id' => Auth::id(),
            'parent_id' => $parentId,
            'content' => $this->replyContent,
            'status' => 'approved',
        ]);

        $this->replyTo = null;
        $this->replyContent = '';
        $this->dispatch('toast', type: 'success', message: 'Balasan terkirim.');
    }

    public function toggleLike(int $commentId): void
    {
        if (! Auth::check()) {
            $this->dispatch('toast', type: 'error', message: 'Silakan masuk untuk menyukai komentar.');

            return;
        }

        $existing = CommentLike::where('comment_id', $commentId)->where('user_id', Auth::id())->first();

        if ($existing) {
            $existing->delete();
        } else {
            CommentLike::create(['comment_id' => $commentId, 'user_id' => Auth::id()]);
        }
    }

    public function render()
    {
        $comments = $this->article->approvedComments()
            ->with([
                'author',
                'likes',
                'replies' => fn ($q) => $q->where('status', 'approved')->with(['author', 'likes']),
            ])
            ->latest()
            ->get();

        return view('livewire.frontend.comment-section', ['comments' => $comments]);
    }
}
