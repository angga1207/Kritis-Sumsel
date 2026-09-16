@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-1.5 rounded-lg bg-success/10 px-3 py-2 text-sm font-medium text-success']) }}>
        <x-heroicon-s-check-circle class="h-4 w-4 shrink-0" />
        {{ $status }}
    </div>
@endif
