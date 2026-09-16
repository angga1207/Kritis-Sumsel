<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin', ['title' => 'Moderasi Komentar'])]
class CommentModeration extends Component
{
    use AuthorizesRequests, WithPagination;

    #[Url]
    public string $filter = 'pending';

    public function mount(): void
    {
        $this->authorize('comments.moderate');
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function approve(Comment $comment): void
    {
        $this->authorize('comments.moderate');
        $comment->update(['status' => 'approved']);
        $this->dispatch('toast', type: 'success', message: 'Komentar disetujui.');
    }

    public function markSpam(Comment $comment): void
    {
        $this->authorize('comments.moderate');
        $comment->update(['status' => 'spam']);
        $this->dispatch('toast', type: 'success', message: 'Komentar ditandai spam.');
    }

    public function delete(Comment $comment): void
    {
        $this->authorize('comments.moderate');
        $comment->delete();
        $this->dispatch('toast', type: 'success', message: 'Komentar dihapus.');
    }

    public function render()
    {
        $query = Comment::with(['article', 'author']);

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        return view('livewire.admin.comment-moderation', [
            'comments' => $query->latest()->paginate(15),
        ]);
    }
}
