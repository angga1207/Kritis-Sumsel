@props(['count' => 3])

@for ($i = 0; $i < $count; $i++)
    <div class="overflow-hidden rounded-lg bg-white ring-1 ring-black/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="skeleton aspect-[16/10] w-full"></div>
        <div class="space-y-2 p-4">
            <div class="skeleton h-4 w-3/4"></div>
            <div class="skeleton h-4 w-1/2"></div>
            <div class="skeleton h-3 w-1/3"></div>
        </div>
    </div>
@endfor
