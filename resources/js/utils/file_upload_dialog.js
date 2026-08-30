import { ref } from 'vue';

// Singleton dialog untuk upload file baru (mode create) atau ganti isi file (mode replace)
export const _uploadDialog = ref({
    show: false,
    mode: 'create', // 'create' | 'replace'
    onSubmit: null, // ({ file, name, description }) => void
});

export function openUploadDialog({ mode = 'create', onSubmit }) {
    _uploadDialog.value = { show: true, mode, onSubmit };
}

export function closeUploadDialog() {
    _uploadDialog.value.show = false;
}
