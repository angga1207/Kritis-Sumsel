<div>
    @if ($main)
        <section class="mx-auto max-w-7xl px-4 py-8">
            <x-section-title :title="$category->name" :link="route('category.show', $category->slug)" />

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-1">
                    <x-news-card :article="$main" variant="vertical" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-2">
                    @foreach ($rest->take(4) as $article)
                        <x-news-card :article="$article" variant="horizontal" :aos="'fade-up'" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
