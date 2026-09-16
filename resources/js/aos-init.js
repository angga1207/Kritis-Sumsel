import AOS from 'aos';
import 'aos/dist/aos.css';

function initAOS() {
    AOS.init({
        duration: 600,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
    });
}

document.addEventListener('DOMContentLoaded', initAOS);
document.addEventListener('livewire:navigated', () => AOS.refreshHard());

document.addEventListener('livewire:init', () => {
    Livewire.hook('morphed', () => AOS.refresh());
});

export { AOS };
