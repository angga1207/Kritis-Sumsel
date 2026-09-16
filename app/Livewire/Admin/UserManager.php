<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.admin', ['title' => 'Manajemen Pengguna'])]
class UserManager extends Component
{
    use AuthorizesRequests;

    public bool $showModal = false;

    public ?User $editing = null;

    public string $name = '';

    public string $email = '';

    public string $username = '';

    public string $password = '';

    public string $role = 'author';

    public bool $isActive = true;

    public function mount(): void
    {
        $this->authorize('users.manage');
    }

    public function create(): void
    {
        $this->editing = null;
        $this->reset(['name', 'email', 'username', 'password']);
        $this->role = 'author';
        $this->isActive = true;
        $this->showModal = true;
    }

    public function edit(User $user): void
    {
        $this->editing = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = (string) $user->username;
        $this->password = '';
        $this->role = $user->roles->first()?->name ?? 'author';
        $this->isActive = $user->is_active;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editing?->id)],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->editing?->id)],
            'password' => $this->editing ? 'nullable|string|min:8' : 'required|string|min:8',
            'role' => 'required|in:super_admin,editor,author',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username ?: null,
            'is_active' => $this->isActive,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editing) {
            $this->editing->update($data);
            $user = $this->editing;
        } else {
            $data['email_verified_at'] = now();
            $user = User::create($data);
        }

        $user->syncRoles([$this->role]);

        $this->showModal = false;
        $this->dispatch('toast', type: 'success', message: 'Pengguna berhasil disimpan.');
    }

    public function delete(User $user): void
    {
        if ($user->id === auth()->id()) {
            $this->dispatch('toast', type: 'error', message: 'Tidak dapat menghapus akun sendiri.');

            return;
        }

        $user->delete();
        $this->dispatch('toast', type: 'success', message: 'Pengguna berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.user-manager', [
            'users' => User::with('roles')->latest()->paginate(15),
            'roles' => Role::pluck('name'),
        ]);
    }
}
