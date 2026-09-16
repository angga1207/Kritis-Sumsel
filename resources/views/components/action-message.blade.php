@props(['on'])

<div x-data="{ shown: false, timeout: null }"
     x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
     x-show.transition.out.opacity.duration.1500ms="shown"
     x-transition:leave.opacity.duration.1500ms
     style="display: none;"
    {{ $attributes->merge(['class' => 'flex items-center gap-1.5 text-sm font-medium text-success']) }}>
    <x-heroicon-s-check-circle class="h-4 w-4" />
    {{ $slot->isEmpty() ? __('Saved.') : $slot }}
</div>
