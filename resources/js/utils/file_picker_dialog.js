import { ref } from 'vue';

// Singleton dialog picker berfolder (browse mt_files_storage) untuk form entity.
// filter: 'image' | 'pdf' | null (semua). onPick(file) dipanggil saat file dipilih.
export const _filePicker = ref({
    show: false,
    filter: null,
    onPick: null,
});

export function openFilePicker({ filter = null, onPick }) {
    _filePicker.value = { show: true, filter, onPick };
}

export function closeFilePicker() {
    _filePicker.value.show = false;
}
