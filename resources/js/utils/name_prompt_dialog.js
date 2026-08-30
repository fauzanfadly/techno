import { ref } from 'vue';

// Singleton dialog untuk input satu nama (buat folder / rename folder / rename file)
export const _namePrompt = ref({
    show: false,
    title: 'Input Nama',
    label: 'Nama',
    name: '',
    confirmText: 'Simpan',
    onSubmit: null,
});

export function openNamePrompt({ title = 'Input Nama', label = 'Nama', name = '', confirmText = 'Simpan', onSubmit }) {
    _namePrompt.value = { show: true, title, label, name, confirmText, onSubmit };
}

export function closeNamePrompt() {
    _namePrompt.value.show = false;
}
