<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-4">
    <p class="text-sm text-gray-500">
        {{ __('Setelah akun Anda dihapus, seluruh data akan dihapus secara permanen. Unduh terlebih dahulu data yang ingin Anda simpan sebelum melanjutkan.') }}
    </p>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <x-heroicon-o-trash class="h-3.5 w-3.5" />
        {{ __('Hapus Akun') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="flex items-center gap-2 font-heading text-lg font-bold text-primary-dark">
                <x-heroicon-o-exclamation-triangle class="h-5 w-5 text-danger" />
                {{ __('Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                {{ __('Setelah akun dihapus, seluruh data akan hilang secara permanen. Masukkan password Anda untuk mengonfirmasi.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    <x-heroicon-o-trash class="h-3.5 w-3.5" />
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
