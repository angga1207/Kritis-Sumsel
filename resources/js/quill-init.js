import Quill from 'quill';
import 'quill/dist/quill.snow.css';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('quillEditor', (initialContent = '') => ({
        quill: null,
        init() {
            this.quill = new Quill(this.$refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'link', 'image'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean'],
                    ],
                },
            });

            if (initialContent) {
                requestAnimationFrame(() => {
                    this.quill.clipboard.dangerouslyPasteHTML(0, initialContent, 'silent');
                });
            }

            this.quill.on('text-change', () => {
                this.$wire.set('content', this.quill.root.innerHTML, false);
            });
        },
    }));
});
