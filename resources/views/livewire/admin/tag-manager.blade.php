<div class="space-y-6">
    <x-admin.page-header title="Tag" subtitle="Kelola tag untuk pengelompokan topik artikel." icon="hashtag">
        <x-slot:actions>
            <button wire:click="create" class="btn-primary">
                <x-heroicon-o-plus class="h-4 w-4" />
                Tambah Tag
            </button>
        </x-slot:actions>
    </x-admin.page-header>

    <x-admin.card>
        @if ($tags->isEmpty())
            <x-admin.empty-state icon="hashtag" title="Belum ada tag" />
        @else
            <div class="flex flex-wrap gap-2.5">
                @foreach ($tags as $tag)
                    <div wire:key="tag-{{ $tag->id }}"
                        class="group flex items-center gap-2 rounded-full bg-secondary/60 py-1.5 pl-3.5 pr-2 text-sm transition hover:bg-secondary">
                        <span class="font-medium text-primary-dark">#{{ $tag->name }}</span>
                        <span class="text-xs text-gray-400">{{ $tag->articles_count }}</span>
                        <button wire:click="edit({{ $tag->id }})" class="rounded-full p-1 text-primary-light transition hover:bg-white" title="Edit">
                            <x-heroicon-o-pencil-square class="h-3.5 w-3.5" />
                        </button>
                        <button type="button" x-data
                            x-on:click="if (await confirmDelete()) $wire.delete({{ $tag->id }})"
                            class="rounded-full p-1 text-danger transition hover:bg-white" title="Hapus">
                            <x-heroicon-o-trash class="h-3.5 w-3.5" />
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </x-admin.card>

    <x-admin.modal x-cloak x-show="$wire.showModal" max-width="sm" :title="$editing ? 'Edit Tag' : 'Tambah Tag'">
        <input type="text" wire:model="name" placeholder="Nama tag" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
        @error('name') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
        <div class="mt-5 flex justify-end gap-2">
            <button wire:click="$set('showModal', false)" class="btn-ghost">Batal</button>
            <button wire:click="save" wire:loading.attr="disabled" class="btn-primary">Simpan</button>
        </div>
    </x-admin.modal>
</div>
