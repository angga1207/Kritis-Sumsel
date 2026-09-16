<form wire:submit="subscribe" class="flex gap-2">
    <input type="email" wire:model="email" placeholder="Email Anda"
        class="w-full rounded-md border-0 bg-white/10 px-3 py-2 text-sm text-white placeholder-white/50 focus:bg-white focus:text-primary focus:ring-2 focus:ring-accent">
    <button type="submit" wire:loading.attr="disabled" class="btn-accent shrink-0 !px-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 12h15" />
        </svg>
    </button>
</form>
@error('email') <p class="mt-2 text-xs text-danger">{{ $message }}</p> @enderror
