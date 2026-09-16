<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6">
        <h2 class="font-heading text-2xl font-bold text-primary-dark dark:text-white">Selamat Datang Kembali</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Masuk ke akun redaksi Kritis Sumsel Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <x-heroicon-o-envelope class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <x-text-input wire:model="form.email" id="email" class="block w-full pl-9" type="email" name="email" required autofocus autocomplete="username" placeholder="nama@kritissumsel.com" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-primary-light hover:text-primary dark:text-accent dark:hover:text-accent/80" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>
            <div class="relative mt-1">
                <x-heroicon-o-lock-closed class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <x-text-input wire:model="form.password" id="password" class="block w-full pl-9"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <label for="remember" class="flex items-center gap-2">
            <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary dark:border-gray-600 dark:bg-gray-800" name="remember">
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
        </label>

        <x-primary-button class="w-full justify-center !py-2.5">
            <x-heroicon-o-arrow-right-on-rectangle class="h-4 w-4" />
            {{ __('Masuk') }}
        </x-primary-button>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Belum punya akun?
            <a href="{{ route('register') }}" wire:navigate class="font-semibold text-primary-light hover:text-primary dark:text-accent">Daftar</a>
        </p>
    @endif
</div>
