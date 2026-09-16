import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('tomSelectField', (options = {}) => ({
        instance: null,
        init() {
            this.instance = new TomSelect(this.$refs.select, {
                create: options.create ?? false,
                persist: false,
                plugins: options.multiple ? ['remove_button'] : [],
                onChange: (value) => {
                    this.$wire.set(options.wireModel, value, true);
                },
            });
        },
        destroy() {
            this.instance?.destroy();
        },
    }));
});
