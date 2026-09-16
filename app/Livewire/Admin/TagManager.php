<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin', ['title' => 'Manajemen Tag'])]
class TagManager extends Component
{
    use AuthorizesRequests;

    public bool $showModal = false;

    public ?Tag $editing = null;

    public string $name = '';

    public function create(): void
    {
        $this->authorize('tags.manage');
        $this->editing = null;
        $this->reset('name');
        $this->showModal = true;
    }

    public function edit(Tag $tag): void
    {
        $this->authorize('tags.manage');
        $this->editing = $tag;
        $this->name = $tag->name;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->authorize('tags.manage');
        $this->validate(['name' => 'required|string|max:255']);

        if ($this->editing) {
            $this->editing->update(['name' => $this->name]);
        } else {
            Tag::create(['name' => $this->name]);
        }

        $this->showModal = false;
        $this->reset('name');
        $this->dispatch('toast', type: 'success', message: 'Tag berhasil disimpan.');
    }

    public function delete(Tag $tag): void
    {
        $this->authorize('tags.manage');
        $tag->delete();
        $this->dispatch('toast', type: 'success', message: 'Tag berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.tag-manager', [
            'tags' => Tag::withCount('articles')->orderBy('name')->get(),
        ]);
    }
}
