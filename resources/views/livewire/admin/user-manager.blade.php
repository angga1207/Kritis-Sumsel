<div class="space-y-6">
    <x-admin.page-header title="Pengguna" subtitle="Kelola akun dan hak akses tim redaksi." icon="users">
        <x-slot:actions>
            <button wire:click="create" class="btn-primary">
                <x-heroicon-o-plus class="h-4 w-4" />
                Tambah Pengguna
            </button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card no-padding>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-secondary/40 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Peran</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="transition hover:bg-secondary/20">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </span>
                                    <span class="font-medium text-primary-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $user->email }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $user->roles->first()?->name ?? '-' }}</td>
                            <td class="px-5 py-3">
                                <x-admin.badge :variant="$user->is_active ? 'success' : 'neutral'">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </x-admin.badge>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="edit({{ $user->id }})" class="rounded-lg p-1.5 text-primary-light transition hover:bg-primary/10" title="Edit">
                                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                                    </button>
                                    <button type="button" x-data
                                        x-on:click="if (await confirmDelete()) $wire.delete({{ $user->id }})"
                                        class="rounded-lg p-1.5 text-danger transition hover:bg-danger/10" title="Hapus">
                                        <x-heroicon-o-trash class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><x-admin.empty-state icon="users" title="Belum ada pengguna" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-admin.card>

    <div>{{ $users->links() }}</div>

    <x-admin.modal x-cloak x-show="$wire.showModal" :title="$editing ? 'Edit Pengguna' : 'Tambah Pengguna'">
        <div class="space-y-3">
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Nama</label>
                <input type="text" wire:model="name" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                @error('name') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Email</label>
                <input type="email" wire:model="email" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                @error('email') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Username</label>
                <input type="text" wire:model="username" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                @error('username') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Password {{ $editing ? '(kosongkan jika tidak diubah)' : '' }}</label>
                <input type="password" wire:model="password" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                @error('password') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Peran</label>
                <select wire:model="role" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @foreach ($roles as $r)
                        <option value="{{ $r }}">{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" wire:model="isActive" class="rounded border-gray-300 text-primary focus:ring-primary">
                Aktif
            </label>
        </div>

        <div class="mt-5 flex justify-end gap-2">
            <button wire:click="$set('showModal', false)" class="btn-ghost">Batal</button>
            <button wire:click="save" wire:loading.attr="disabled" class="btn-primary">Simpan</button>
        </div>
    </x-admin.modal>
</div>
