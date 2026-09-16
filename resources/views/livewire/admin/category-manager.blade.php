<div class="space-y-6">
    <x-admin.page-header title="Kategori" subtitle="Atur struktur kategori dan sub-kategori artikel." icon="tag">
        <x-slot:actions>
            <button wire:click="create" class="btn-primary">
                <x-heroicon-o-plus class="h-4 w-4" />
                Tambah Kategori
            </button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card no-padding>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-secondary/40 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Induk</th>
                        <th class="px-5 py-3">Artikel</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary">
                    @forelse ($categories as $category)
                        <tr wire:key="category-{{ $category->id }}" class="transition hover:bg-secondary/20">
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-2 font-medium text-primary-dark">
                                    <span class="h-3 w-3 rounded-full ring-2 ring-white ring-offset-1" style="background-color: {{ $category->color }}"></span>
                                    {{ $category->name }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $category->parent->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $category->articles()->count() }}</td>
                            <td class="px-5 py-3">
                                <x-admin.badge :variant="$category->is_active ? 'success' : 'neutral'">
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </x-admin.badge>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="edit({{ $category->id }})" class="rounded-lg p-1.5 text-primary-light transition hover:bg-primary/10" title="Edit">
                                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                                    </button>
                                    <button type="button" x-data
                                        x-on:click="if (await confirmDelete()) $wire.delete({{ $category->id }})"
                                        class="rounded-lg p-1.5 text-danger transition hover:bg-danger/10" title="Hapus">
                                        <x-heroicon-o-trash class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><x-admin.empty-state icon="tag" title="Belum ada kategori" /></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-admin.card>

    <x-admin.modal x-cloak x-show="$wire.showModal" :title="$editing ? 'Edit Kategori' : 'Tambah Kategori'">
            <div class="space-y-3">
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-500">Nama</label>
                    <input type="text" wire:model="name" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('name') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-xs font-medium text-gray-500">Deskripsi</label>
                    <textarea wire:model="description" rows="2" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500">Warna</label>
                        <input type="color" wire:model="color" class="h-9 w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-500">Induk Kategori</label>
                        <select wire:model="parentId" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <option value="">Tanpa induk</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
