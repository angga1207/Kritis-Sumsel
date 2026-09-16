<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin', ['title' => 'Manajemen Kategori'])]
class CategoryManager extends Component
{
    use AuthorizesRequests;

    public bool $showModal = false;

    public ?Category $editing = null;

    public string $name = '';

    public string $description = '';

    public string $color = '#0B2545';

    public ?int $parentId = null;

    public bool $isActive = true;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|max:7',
            'parentId' => 'nullable|exists:categories,id',
            'isActive' => 'boolean',
        ];
    }

    public function create(): void
    {
        $this->authorize('categories.manage');
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(Category $category): void
    {
        $this->authorize('categories.manage');
        $this->editing = $category;
        $this->name = $category->name;
        $this->description = (string) $category->description;
        $this->color = $category->color;
        $this->parentId = $category->parent_id;
        $this->isActive = $category->is_active;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->authorize('categories.manage');
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'parent_id' => $this->parentId,
            'is_active' => $this->isActive,
        ];

        if ($this->editing) {
            $this->editing->update($data);
        } else {
            Category::create($data);
        }

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('toast', type: 'success', message: 'Kategori berhasil disimpan.');
    }

    public function delete(Category $category): void
    {
        $this->authorize('categories.manage');
        $category->delete();
        $this->dispatch('toast', type: 'success', message: 'Kategori berhasil dihapus.');
    }

    protected function resetForm(): void
    {
        $this->editing = null;
        $this->reset(['name', 'description', 'parentId']);
        $this->color = '#0B2545';
        $this->isActive = true;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => Category::with('parent')->orderBy('order')->orderBy('name')->get(),
        ]);
    }
}
