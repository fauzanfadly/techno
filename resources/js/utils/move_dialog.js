import { ref } from 'vue';

// Singleton dialog untuk memilih folder tujuan (move folder / move file)
export const _moveDialog = ref({
    show: false,
    title: 'Pindahkan',
    nodes: [],
    excludeId: null, // folder yang sedang dipindah (tidak boleh jadi tujuan)
    onSubmit: null,
});

export function openMoveDialog({ title = 'Pindahkan', nodes = [], excludeId = null, onSubmit }) {
    _moveDialog.value = { show: true, title, nodes, excludeId, onSubmit };
}

export function closeMoveDialog() {
    _moveDialog.value.show = false;
}
