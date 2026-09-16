@props(['url', 'title' => '', 'trigger' => 'button'])

<div {{ $attributes->merge(['class' => 'relative inline-block']) }}
    x-data="{
        open: false,
        copied: false,
        shareUrl: @js($url),
        shareTitle: @js($title),
        async share() {
            if (navigator.share) {
                try { await navigator.share({ title: this.shareTitle, url: this.shareUrl }); } catch (e) {}
            } else {
                this.open = !this.open;
            }
        },
        async copyLink() {
            try {
                await navigator.clipboard.writeText(this.shareUrl);
            } catch (e) {
                const el = document.createElement('textarea');
                el.value = this.shareUrl;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
            }
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        },
    }"
    @click.outside="open = false">

    @if ($trigger === 'icon')
        <button type="button" @click.prevent.stop="share()"
            class="flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur transition hover:bg-primary active:scale-95"
            aria-label="Bagikan artikel" title="Bagikan">
            <x-heroicon-o-share class="h-4 w-4" />
        </button>
    @elseif ($trigger === 'ghost')
        <button type="button" @click="share()"
            class="flex h-8 w-8 items-center justify-center rounded-full text-gray-500 transition hover:bg-secondary hover:text-primary active:scale-95 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-accent"
            aria-label="Bagikan artikel" title="Bagikan">
            <x-heroicon-o-share class="h-4 w-4" />
        </button>
    @else
        <button type="button" @click="share()"
            class="flex items-center gap-1.5 rounded-full bg-secondary px-3 py-1.5 text-sm font-medium text-gray-600 transition active:scale-95 hover:bg-secondary/70 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
            <x-heroicon-o-share class="h-4 w-4" />
            Bagikan
        </button>
    @endif

    <div x-show="open" x-cloak x-transition.origin.top.right @click.stop
        class="absolute {{ in_array($trigger, ['icon', 'ghost']) ? 'right-0' : 'left-0' }} top-full z-30 mt-2 w-56 overflow-hidden rounded-xl bg-white py-1.5 shadow-lg ring-1 ring-black/5 dark:bg-gray-800 dark:ring-white/10"
        <a :href="'https://wa.me/?text=' + encodeURIComponent(shareTitle + ' ' + shareUrl)" target="_blank" rel="noopener"
            class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 transition hover:bg-secondary dark:text-gray-200 dark:hover:bg-gray-700">
            <svg class="h-4 w-4 shrink-0 text-[#25D366]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.38a9.9 9.9 0 0 0 4.75 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2m0 1.8a8.1 8.1 0 0 1 5.76 2.38 8.06 8.06 0 0 1 2.38 5.73c0 4.48-3.65 8.12-8.15 8.12a8.13 8.13 0 0 1-4.14-1.13l-.3-.17-3.14.82.84-3.06-.19-.32a8.06 8.06 0 0 1-1.25-4.32c0-4.48 3.65-8.05 8.19-8.05m-4.49 4.6c-.16 0-.43.06-.65.31-.22.25-.86.84-.86 2.04 0 1.2.88 2.36 1 2.53.13.16 1.72 2.7 4.23 3.68 2.08.83 2.5.66 2.96.62.45-.04 1.46-.6 1.67-1.17.2-.58.2-1.08.14-1.18-.06-.1-.23-.16-.48-.28-.25-.13-1.47-.73-1.7-.81-.23-.08-.39-.13-.56.13-.16.25-.64.81-.78.97-.15.16-.29.19-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.48-1.38-1.73-.15-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.24-.42.08-.16.04-.31-.02-.44-.06-.13-.56-1.36-.78-1.86-.2-.48-.41-.42-.56-.43z"/></svg>
            WhatsApp
        </a>
        <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shareUrl)" target="_blank" rel="noopener"
            class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 transition hover:bg-secondary dark:text-gray-200 dark:hover:bg-gray-700">
            <svg class="h-4 w-4 shrink-0 text-[#1877F2]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.3c-.28-.04-1.23-.12-2.34-.12-2.32 0-3.9 1.42-3.9 4.02v2.3H8v3h2.36V21z"/></svg>
            Facebook
        </a>
        <a :href="'https://twitter.com/intent/tweet?text=' + encodeURIComponent(shareTitle) + '&url=' + encodeURIComponent(shareUrl)" target="_blank" rel="noopener"
            class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 transition hover:bg-secondary dark:text-gray-200 dark:hover:bg-gray-700">
            <svg class="h-4 w-4 shrink-0 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 2H22l-7.6 8.7L23.3 22H16.6l-5.2-6.8L5.4 22H2.3l8.1-9.3L1.7 2h6.9l4.7 6.2zm-1.2 18h1.7L7.4 4H5.6z"/></svg>
            X (Twitter)
        </a>
        <a :href="'https://t.me/share/url?url=' + encodeURIComponent(shareUrl) + '&text=' + encodeURIComponent(shareTitle)" target="_blank" rel="noopener"
            class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-600 transition hover:bg-secondary dark:text-gray-200 dark:hover:bg-gray-700">
            <svg class="h-4 w-4 shrink-0 text-[#26A5E4]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 3.5 19 20c-.2 1-.8 1.2-1.6.7l-4.5-3.3-2.2 2.1c-.2.2-.4.4-.8.4l.3-4.1L18.9 8c.4-.3-.1-.5-.6-.2L7 14.3l-4.3-1.3c-.9-.3-.9-.9.2-1.3L20.7 4.1c.8-.3 1.5.2 1.3 1.4z"/></svg>
            Telegram
        </a>
        <button type="button" @click="copyLink()"
            class="flex w-full items-center gap-2.5 px-4 py-2 text-sm text-gray-600 transition hover:bg-secondary dark:text-gray-200 dark:hover:bg-gray-700">
            <x-heroicon-o-link class="h-4 w-4 shrink-0" />
            <span x-text="copied ? 'Tautan tersalin!' : 'Salin Tautan'"></span>
        </button>
    </div>
</div>
