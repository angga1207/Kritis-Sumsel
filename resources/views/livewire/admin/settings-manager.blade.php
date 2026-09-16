<div class="mx-auto max-w-2xl space-y-6">
    <x-admin.page-header title="Pengaturan" subtitle="Kelola informasi umum dan integrasi situs." icon="cog-6-tooth" />

    <x-admin.card title="Informasi Situs" icon="globe-alt">
        <div class="space-y-3">
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Nama Situs</label>
                <input type="text" wire:model="siteName" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Tagline</label>
                <input type="text" wire:model="siteTagline" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Meta Description Default</label>
                <textarea wire:model="metaDescriptionDefault" rows="2" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
            </div>
        </div>
    </x-admin.card>

    <x-admin.card title="Identitas Visual" subtitle="Logo dan favicon akan otomatis tersinkron ke header, sidebar admin, halaman login, dan tab browser." icon="photo" :delay="25">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-xs font-medium text-gray-500 dark:text-gray-400">Logo Situs</label>
                <div class="mb-3 flex h-20 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-secondary/50 p-3 dark:border-gray-700 dark:bg-white/5">
                    @if ($logoUpload)
                        <img src="{{ $logoUpload->temporaryUrl() }}" class="max-h-full max-w-full object-contain" alt="Pratinjau logo">
                    @elseif ($existingLogo)
                        <img src="{{ $existingLogo }}" class="max-h-full max-w-full object-contain" alt="Logo saat ini">
                    @else
                        <span class="flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
                            <x-heroicon-o-photo class="h-4 w-4" /> Memakai logo bawaan
                        </span>
                    @endif
                </div>
                <input type="file" wire:model="logoUpload" accept="image/*"
                    class="w-full text-xs text-gray-500 file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-primary-light dark:text-gray-400">
                @error('logoUpload') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                <div wire:loading wire:target="logoUpload" class="mt-1 text-xs text-gray-400">Mengunggah...</div>
                @if ($existingLogo && ! $logoUpload)
                    <button type="button" wire:click="removeLogo" wire:confirm="Hapus logo dan kembali ke bawaan?" class="mt-2 text-xs font-medium text-danger hover:underline">
                        Hapus logo
                    </button>
                @endif
            </div>

            <div>
                <label class="mb-2 block text-xs font-medium text-gray-500 dark:text-gray-400">Favicon</label>
                <div class="mb-3 flex h-20 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-secondary/50 p-3 dark:border-gray-700 dark:bg-white/5">
                    @if ($faviconUpload)
                        <img src="{{ $faviconUpload->temporaryUrl() }}" class="h-10 w-10 object-contain" alt="Pratinjau favicon">
                    @elseif ($existingFavicon)
                        <img src="{{ $existingFavicon }}" class="h-10 w-10 object-contain" alt="Favicon saat ini">
                    @else
                        <span class="flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
                            <x-heroicon-o-globe-alt class="h-4 w-4" /> Memakai favicon bawaan
                        </span>
                    @endif
                </div>
                <input type="file" wire:model="faviconUpload" accept="image/png,image/x-icon,image/svg+xml,image/webp,.ico"
                    class="w-full text-xs text-gray-500 file:mr-3 file:rounded-md file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-primary-light dark:text-gray-400">
                @error('faviconUpload') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                <div wire:loading wire:target="faviconUpload" class="mt-1 text-xs text-gray-400">Mengunggah...</div>
                @if ($existingFavicon && ! $faviconUpload)
                    <button type="button" wire:click="removeFavicon" wire:confirm="Hapus favicon dan kembali ke bawaan?" class="mt-2 text-xs font-medium text-danger hover:underline">
                        Hapus favicon
                    </button>
                @endif
                <p class="mt-2 text-[11px] text-gray-400 dark:text-gray-500">Format PNG/ICO/SVG, persegi, idealnya 512×512px.</p>
            </div>
        </div>
    </x-admin.card>

    <x-admin.card title="Media Sosial" icon="share" :delay="50">
        <div class="space-y-3">
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" />
                <input type="url" wire:model="facebookUrl" placeholder="URL Facebook" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" />
                <input type="url" wire:model="twitterUrl" placeholder="URL Twitter/X" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" />
                <input type="url" wire:model="instagramUrl" placeholder="URL Instagram" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400 dark:text-gray-500" />
                <input type="url" wire:model="youtubeUrl" placeholder="URL Youtube" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
        </div>
    </x-admin.card>

    <x-admin.card title="Kode Analytics" icon="code-bracket" :delay="100">
        <textarea wire:model="analyticsCode" rows="4" placeholder="<script>...</script>" class="w-full rounded-md border-gray-300 font-mono text-xs focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
    </x-admin.card>

    <button wire:click="save" wire:loading.attr="disabled" class="btn-primary">
        <x-heroicon-o-check class="h-4 w-4" />
        <span wire:loading.remove>Simpan Pengaturan</span>
        <span wire:loading>Menyimpan...</span>
    </button>
</div>
