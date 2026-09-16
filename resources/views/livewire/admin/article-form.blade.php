<div class="mx-auto max-w-5xl">
    <x-admin.page-header
        :title="$article ? 'Edit Artikel' : 'Tulis Artikel'"
        :subtitle="$article ? $article->title : 'Buat artikel baru untuk dipublikasikan.'"
        icon="document-text" />

    <form wire:submit.prevent class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <label class="mb-1 block text-sm font-medium text-gray-700">Judul Artikel</label>
                <input type="text" wire:model="title" placeholder="Judul artikel..."
                    class="w-full rounded-md border-gray-300 text-lg font-semibold focus:border-primary focus:ring-primary">
                @error('title') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror

                <label class="mb-1 mt-4 block text-sm font-medium text-gray-700">Ringkasan (Excerpt)</label>
                <textarea wire:model="excerpt" rows="2" placeholder="Ringkasan singkat artikel..."
                    class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary"></textarea>
                @error('excerpt') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <label class="mb-2 block text-sm font-medium text-gray-700">Konten</label>
                <div wire:ignore x-data="quillEditor(@js($content))">
                    <div x-ref="editor" style="min-height: 320px;"></div>
                </div>
                @error('content') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <h3 class="mb-3 text-sm font-semibold text-gray-700">Galeri Gambar</h3>
                @if (! $article)
                    <p class="text-xs text-gray-400">Simpan artikel terlebih dahulu untuk menambahkan galeri gambar.</p>
                @else
                    @if ($mediaItems->isNotEmpty())
                        <div class="mb-4 grid grid-cols-3 gap-3 sm:grid-cols-4">
                            @foreach ($mediaItems as $item)
                                <div class="group relative aspect-square overflow-hidden rounded-md bg-secondary" wire:key="media-{{ $item->id }}">
                                    <img src="{{ $item->path }}" class="h-full w-full object-cover">
                                    <button type="button" wire:click="deleteMedia({{ $item->id }})"
                                        class="absolute right-1 top-1 rounded-full bg-danger/90 p-1 text-white opacity-0 transition group-hover:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" wire:model="galleryUploads" multiple accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary-light">
                    @error('galleryUploads.*') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="galleryUploads" class="mt-2 text-xs text-gray-400">Mengunggah...</div>
                    @if (! empty($galleryUploads))
                        <button type="button" wire:click="uploadGallery" wire:loading.attr="disabled" class="btn-outline mt-3 !px-3 !py-1.5 !text-xs">
                            Tambahkan {{ count($galleryUploads) }} Gambar ke Galeri
                        </button>
                    @endif
                @endif
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <h3 class="mb-3 text-sm font-semibold text-gray-700">SEO</h3>
                <label class="mb-1 block text-xs font-medium text-gray-500">Meta Title</label>
                <input type="text" wire:model="metaTitle" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                <label class="mb-1 mt-3 block text-xs font-medium text-gray-500">Meta Description</label>
                <textarea wire:model="metaDescription" rows="2" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary"></textarea>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <h3 class="mb-3 text-sm font-semibold text-gray-700">Publikasikan</h3>
                <div class="space-y-2">
                    <button type="button" wire:click="save('published')" wire:loading.attr="disabled" class="btn-primary w-full">
                        <x-heroicon-o-rocket-launch class="h-4 w-4" />
                        Publish
                    </button>
                    <button type="button" wire:click="save('pending')" wire:loading.attr="disabled" class="btn-outline w-full">
                        <x-heroicon-o-paper-airplane class="h-4 w-4" />
                        Ajukan Review
                    </button>
                    <button type="button" wire:click="save('draft')" wire:loading.attr="disabled" class="btn-ghost w-full border border-gray-300">
                        <x-heroicon-o-document class="h-4 w-4" />
                        Simpan Draft
                    </button>
                </div>

                <div class="mt-4 space-y-2 border-t border-secondary pt-4">
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" wire:model="isFeatured" class="rounded border-gray-300 text-primary focus:ring-primary">
                        Featured (tampil di hero slider)
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" wire:model="isBreaking" class="rounded border-gray-300 text-primary focus:ring-primary">
                        Breaking News (tampil di ticker)
                    </label>
                </div>
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <h3 class="mb-3 text-sm font-semibold text-gray-700">Gambar Utama</h3>
                @if ($existingImage && ! $featuredImageUpload)
                    <img src="{{ $existingImage }}" class="mb-3 aspect-video w-full rounded-md object-cover">
                @endif
                @if ($featuredImageUpload)
                    <img src="{{ $featuredImageUpload->temporaryUrl() }}" class="mb-3 aspect-video w-full rounded-md object-cover">
                @endif
                <input type="file" wire:model="featuredImageUpload" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary-light">
                @error('featuredImageUpload') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                <div wire:loading wire:target="featuredImageUpload" class="mt-2 text-xs text-gray-400">Mengunggah...</div>
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <h3 class="mb-3 text-sm font-semibold text-gray-700">Kategori</h3>
                <div wire:ignore x-data="tomSelectField({ wireModel: 'categoryId' })">
                    <select x-ref="select" x-init="instance.setValue(@js((string) $categoryId), true)">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('categoryId') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
            </div>

            <div class="rounded-lg bg-white p-5 shadow-sm ring-1 ring-black/5">
                <h3 class="mb-3 text-sm font-semibold text-gray-700">Tag</h3>
                <div wire:ignore x-data="tomSelectField({ wireModel: 'selectedTags', multiple: true })">
                    <select multiple x-ref="select" x-init="instance.setValue(@js($selectedTags), true)">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
