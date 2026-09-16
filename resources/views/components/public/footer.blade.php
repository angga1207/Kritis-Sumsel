@php
    $footerCategories = \App\Models\Category::active()->whereNull('parent_id')->orderBy('order')->take(8)->get();
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
    $siteLogo = \App\Models\Setting::get('site_logo', '');
    $siteTagline = \App\Models\Setting::get('site_tagline', 'Kanal berita independen yang menyajikan informasi kritis, akurat, dan terkini seputar Sumatera Selatan.');
    $socials = [
        'Facebook' => \App\Models\Setting::get('facebook_url', ''),
        'Twitter' => \App\Models\Setting::get('twitter_url', ''),
        'Instagram' => \App\Models\Setting::get('instagram_url', ''),
        'Youtube' => \App\Models\Setting::get('youtube_url', ''),
    ];
@endphp
<footer class="mt-16 bg-primary-dark text-white">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-12 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            @if ($siteLogo)
                <span class="inline-flex rounded-lg bg-white/95 p-1.5 shadow-sm">
                    <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-7 w-auto max-w-[150px] object-contain">
                </span>
            @else
                <span class="font-heading text-xl font-extrabold text-white">
                    @if (Str::contains($siteName, 'Sumsel'))
                        {{ trim(Str::before($siteName, 'Sumsel')) }}<span class="text-accent">Sumsel</span>{{ trim(Str::after($siteName, 'Sumsel')) }}
                    @else
                        {{ $siteName }}
                    @endif
                </span>
            @endif
            <p class="mt-3 text-sm leading-relaxed text-white/70">
                {{ $siteTagline }}
            </p>
            <div class="mt-4 flex gap-3">
                @php
                    $socialIcons = [
                        'Facebook' => '<path d="M13.5 21v-7.5h2.5l.4-3H13.5V8.4c0-.87.24-1.46 1.5-1.46h1.6V4.3c-.28-.04-1.23-.12-2.34-.12-2.32 0-3.9 1.42-3.9 4.02v2.3H8v3h2.36V21z"/>',
                        'Twitter' => '<path d="M18.9 2H22l-7.6 8.7L23.3 22H16.6l-5.2-6.8L5.4 22H2.3l8.1-9.3L1.7 2h6.9l4.7 6.2zm-1.2 18h1.7L7.4 4H5.6z"/>',
                        'Instagram' => '<path d="M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.22.6 1.77 1.15.5.5.9 1.11 1.15 1.77.25.64.42 1.37.47 2.43C21.99 8.94 22 9.28 22 12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 0 1-1.15 1.77 4.9 4.9 0 0 1-1.77 1.15c-.64.25-1.37.42-2.43.47C15.06 21.99 14.72 22 12 22s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 0 1-1.77-1.15 4.9 4.9 0 0 1-1.15-1.77c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.22 1.15-1.77.5-.5 1.11-.9 1.77-1.15.64-.25 1.37-.42 2.43-.47C8.94 2.01 9.28 2 12 2m0 1.8c-2.67 0-2.99.01-4.04.06-.86.04-1.33.18-1.64.3-.41.16-.71.35-1.02.66-.31.31-.5.61-.66 1.02-.12.31-.26.78-.3 1.64C4.29 9.01 4.28 9.33 4.28 12s.01 2.99.06 4.04c.04.86.18 1.33.3 1.64.16.41.35.71.66 1.02.31.31.61.5 1.02.66.31.12.78.26 1.64.3 1.05.05 1.37.06 4.04.06s2.99-.01 4.04-.06c.86-.04 1.33-.18 1.64-.3.41-.16.71-.35 1.02-.66.31-.31.5-.61.66-1.02.12-.31.26-.78.3-1.64.05-1.05.06-1.37.06-4.04s-.01-2.99-.06-4.04c-.04-.86-.18-1.33-.3-1.64a2.76 2.76 0 0 0-.66-1.02 2.76 2.76 0 0 0-1.02-.66c-.31-.12-.78-.26-1.64-.3C14.99 3.81 14.67 3.8 12 3.8m0 3.05a5.15 5.15 0 1 1 0 10.3 5.15 5.15 0 0 1 0-10.3m0 1.8a3.35 3.35 0 1 0 0 6.7 3.35 3.35 0 0 0 0-6.7m5.35-1.99a1.2 1.2 0 1 1-2.4 0 1.2 1.2 0 0 1 2.4 0"/>',
                        'Youtube' => '<path d="M21.8 8.1s-.2-1.42-.82-2.05c-.78-.83-1.66-.83-2.06-.88C15.99 5 12 5 12 5h-.01s-3.99 0-6.92.17c-.4.05-1.28.05-2.06.88-.62.63-.82 2.05-.82 2.05S2 9.76 2 11.42v1.55c0 1.66.2 3.32.2 3.32s.2 1.42.82 2.05c.78.83 1.8.8 2.26.89 1.64.16 6.72.21 6.72.21s4-.01 6.93-.17c.4-.05 1.28-.05 2.06-.88.62-.63.82-2.05.82-2.05s.2-1.66.2-3.32v-1.55c0-1.66-.2-3.32-.2-3.32M9.99 14.98v-5.6l5.4 2.81z"/>',
                    ];
                @endphp
                @foreach ($socials as $social => $url)
                    @if ($url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $social }}"
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white/80 transition hover:bg-accent hover:text-primary-dark">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">{!! $socialIcons[$social] ?? '' !!}</svg>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div>
            <h4 class="mb-4 flex items-center gap-2 font-heading text-sm font-bold uppercase tracking-wide text-accent">
                <x-heroicon-o-squares-2x2 class="h-4 w-4" /> Kategori
            </h4>
            <ul class="space-y-2 text-sm text-white/70">
                @foreach ($footerCategories as $category)
                    <li>
                        <a href="{{ route('category.show', $category->slug) }}" wire:navigate class="flex items-center gap-1.5 hover:text-accent">
                            <x-heroicon-o-chevron-right class="h-3 w-3 shrink-0" /> {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h4 class="mb-4 flex items-center gap-2 font-heading text-sm font-bold uppercase tracking-wide text-accent">
                <x-heroicon-o-information-circle class="h-4 w-4" /> Tentang
            </h4>
            <ul class="space-y-2 text-sm text-white/70">
                <li><a href="{{ route('page.about') }}" wire:navigate class="flex items-center gap-1.5 hover:text-accent"><x-heroicon-o-chevron-right class="h-3 w-3 shrink-0" /> Tentang Kami</a></li>
                <li><a href="{{ route('page.redaksi') }}" wire:navigate class="flex items-center gap-1.5 hover:text-accent"><x-heroicon-o-chevron-right class="h-3 w-3 shrink-0" /> Redaksi</a></li>
                <li><a href="{{ route('page.privacy') }}" wire:navigate class="flex items-center gap-1.5 hover:text-accent"><x-heroicon-o-chevron-right class="h-3 w-3 shrink-0" /> Kebijakan Privasi</a></li>
                <li><a href="{{ route('page.contact') }}" wire:navigate class="flex items-center gap-1.5 hover:text-accent"><x-heroicon-o-chevron-right class="h-3 w-3 shrink-0" /> Kontak</a></li>
            </ul>
        </div>

        <div>
            <h4 class="mb-4 flex items-center gap-2 font-heading text-sm font-bold uppercase tracking-wide text-accent">
                <x-heroicon-o-envelope class="h-4 w-4" /> Newsletter
            </h4>
            <p class="mb-3 text-sm text-white/70">Dapatkan berita pilihan langsung ke email Anda.</p>
            <livewire:frontend.newsletter-form />
        </div>
    </div>

    <div class="border-t border-white/10 py-4 text-center text-xs text-white/50">
        &copy; {{ date('Y') }} {{ $siteName }}. Seluruh hak cipta dilindungi.
    </div>
</footer>
