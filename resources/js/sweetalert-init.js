import Swal from 'sweetalert2';

window.Swal = Swal;

window.toast = (icon, title) => {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon,
        title,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
};

window.confirmDelete = async (message = 'Data yang dihapus tidak dapat dikembalikan.') => {
    const result = await Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
    });
    return result.isConfirmed;
};

document.addEventListener('livewire:init', () => {
    Livewire.on('toast', ({ type = 'success', message = '' }) => window.toast(type, message));
});
