<div class="mx-auto max-w-2xl space-y-6">
    <x-admin.page-header title="Pengaturan" subtitle="Kelola informasi umum dan integrasi situs." icon="cog-6-tooth" />

    <x-admin.card title="Informasi Situs" icon="globe-alt">
        <div class="space-y-3">
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Nama Situs</label>
                <input type="text" wire:model="siteName" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Tagline</label>
                <input type="text" wire:model="siteTagline" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="mb-1 block text-xs font-medium text-gray-500">Meta Description Default</label>
                <textarea wire:model="metaDescriptionDefault" rows="2" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary"></textarea>
            </div>
        </div>
    </x-admin.card>

    <x-admin.card title="Media Sosial" icon="share" :delay="50">
        <div class="space-y-3">
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <input type="url" wire:model="facebookUrl" placeholder="URL Facebook" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <input type="url" wire:model="twitterUrl" placeholder="URL Twitter/X" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <input type="url" wire:model="instagramUrl" placeholder="URL Instagram" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary">
            </div>
            <div class="relative">
                <x-heroicon-o-link class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                <input type="url" wire:model="youtubeUrl" placeholder="URL Youtube" class="w-full rounded-md border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary">
            </div>
        </div>
    </x-admin.card>

    <x-admin.card title="Kode Analytics" icon="code-bracket" :delay="100">
        <textarea wire:model="analyticsCode" rows="4" placeholder="<script>...</script>" class="w-full rounded-md border-gray-300 font-mono text-xs focus:border-primary focus:ring-primary"></textarea>
    </x-admin.card>

    <button wire:click="save" wire:loading.attr="disabled" class="btn-primary">
        <x-heroicon-o-check class="h-4 w-4" />
        <span wire:loading.remove>Simpan Pengaturan</span>
        <span wire:loading>Menyimpan...</span>
    </button>
</div>
