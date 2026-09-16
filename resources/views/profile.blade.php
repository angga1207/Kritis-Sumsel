<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                <x-heroicon-o-user-circle class="h-6 w-6" />
            </span>
            <div>
                <h2 class="font-heading text-xl font-bold text-primary-dark">Profil Saya</h2>
                <p class="text-sm text-gray-500">Kelola informasi akun dan keamanan Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        <x-admin.card title="Informasi Profil" icon="identification">
            <livewire:profile.update-profile-information-form />
        </x-admin.card>

        <x-admin.card title="Ubah Password" icon="key" :delay="50">
            <livewire:profile.update-password-form />
        </x-admin.card>

        <x-admin.card title="Zona Berbahaya" icon="exclamation-triangle" :delay="100">
            <livewire:profile.delete-user-form />
        </x-admin.card>
    </div>
</x-app-layout>
