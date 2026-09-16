@php
    $user = auth()->user();
    $myArticlesCount = \App\Models\Article::where('user_id', $user->id)->count();
    $myPublishedCount = \App\Models\Article::where('user_id', $user->id)->where('status', 'published')->count();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                <x-heroicon-o-home class="h-6 w-6" />
            </span>
            <div>
                <h2 class="font-heading text-xl font-bold text-primary-dark">
                    Halo, {{ explode(' ', $user->name)[0] }} 👋
                </h2>
                <p class="text-sm text-gray-500">Selamat datang kembali di akun Kritis Sumsel Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div data-aos="fade-up" class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Peran Anda</p>
                <p class="mt-1.5 font-heading text-lg font-bold text-primary-dark">{{ Str::headline($user->roles->first()?->name ?? 'Pengguna') }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="50" class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Artikel Saya</p>
                <p class="mt-1.5 font-heading text-lg font-bold text-primary-dark">{{ $myArticlesCount }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Dipublikasikan</p>
                <p class="mt-1.5 font-heading text-lg font-bold text-primary-dark">{{ $myPublishedCount }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <a href="{{ route('admin.dashboard') }}" wire:navigate data-aos="fade-up"
                class="group flex flex-col justify-between rounded-xl bg-primary p-5 text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-white/10 transition-transform duration-300 group-hover:scale-110">
                    <x-heroicon-o-squares-2x2 class="h-5 w-5" />
                </span>
                <span class="mt-6">
                    <span class="block font-heading text-base font-bold">Buka Panel Admin</span>
                    <span class="mt-1 flex items-center gap-1 text-xs text-white/70">
                        Kelola artikel & konten
                        <x-heroicon-s-arrow-right class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" />
                    </span>
                </span>
            </a>

            <a href="{{ route('profile') }}" wire:navigate data-aos="fade-up" data-aos-delay="50"
                class="group flex flex-col justify-between rounded-xl bg-white p-5 shadow-sm ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-accent/20 text-primary-dark transition-transform duration-300 group-hover:scale-110">
                    <x-heroicon-o-user-circle class="h-5 w-5" />
                </span>
                <span class="mt-6">
                    <span class="block font-heading text-base font-bold text-primary-dark">Kelola Profil</span>
                    <span class="mt-1 flex items-center gap-1 text-xs text-gray-400">
                        Ubah nama, email & password
                        <x-heroicon-s-arrow-right class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" />
                    </span>
                </span>
            </a>

            <a href="{{ route('home') }}" target="_blank" data-aos="fade-up" data-aos-delay="100"
                class="group flex flex-col justify-between rounded-xl bg-white p-5 shadow-sm ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-success/10 text-success transition-transform duration-300 group-hover:scale-110">
                    <x-heroicon-o-globe-alt class="h-5 w-5" />
                </span>
                <span class="mt-6">
                    <span class="block font-heading text-base font-bold text-primary-dark">Lihat Situs</span>
                    <span class="mt-1 flex items-center gap-1 text-xs text-gray-400">
                        Buka Kritis Sumsel publik
                        <x-heroicon-s-arrow-right class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" />
                    </span>
                </span>
            </a>
        </div>
    </div>
</x-app-layout>
