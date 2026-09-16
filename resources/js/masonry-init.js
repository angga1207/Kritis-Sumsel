import Masonry from 'masonry-layout';
import imagesLoaded from 'imagesloaded';

const instances = new WeakMap();

function initMasonryContainer(container) {
    if (instances.has(container)) {
        instances.get(container).destroy();
    }

    const masonry = new Masonry(container, {
        itemSelector: '.masonry-item',
        columnWidth: '.masonry-sizer',
        percentPosition: true,
        transitionDuration: '0.3s',
    });

    instances.set(container, masonry);

    imagesLoaded(container).on('progress', () => masonry.layout());

    return masonry;
}

function initAllMasonry() {
    document.querySelectorAll('[data-masonry]').forEach((container) => {
        initMasonryContainer(container);
    });
}

function relayoutAllMasonry() {
    document.querySelectorAll('[data-masonry]').forEach((container) => {
        const masonry = instances.get(container);
        if (masonry) {
            masonry.reloadItems();
            masonry.layout();
        } else {
            initMasonryContainer(container);
        }
    });
}

document.addEventListener('DOMContentLoaded', initAllMasonry);
document.addEventListener('livewire:navigated', initAllMasonry);

document.addEventListener('livewire:init', () => {
    Livewire.hook('morphed', () => relayoutAllMasonry());
});

export { initMasonryContainer, relayoutAllMasonry };
