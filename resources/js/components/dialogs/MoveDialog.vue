<template>
    <v-dialog v-model="_moveDialog.show" max-width="480">
        <v-card>
            <v-card-title>{{ _moveDialog.title }}</v-card-title>
            <v-divider></v-divider>
            <v-card-text style="max-height: 50vh; overflow-y: auto;">
                <div
                    class="move-node d-flex align-center pa-1"
                    :class="{ 'move-selected': chosen === null }"
                    @click="chosen = null"
                >
                    <v-icon size="18" color="amber-darken-2" class="mr-1">mdi-home</v-icon>
                    <span>Root</span>
                </div>
                <folder-tree
                    :nodes="_moveDialog.nodes"
                    :selected-id="chosen"
                    :open-ids="openIds"
                    :disabled-id="_moveDialog.excludeId"
                    @select="onSelect"
                    @toggle="toggle"
                ></folder-tree>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="closeMoveDialog">Batal</v-btn>
                <v-btn color="deep-orange" @click="submit">Pindahkan ke sini</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, watch } from 'vue';
import { _moveDialog, closeMoveDialog } from '../../utils/move_dialog';
import FolderTree from '../asset-manager/FolderTree.vue';

const chosen = ref(null);
const openIds = ref([]);

// Reset pilihan tiap dialog dibuka
watch(() => _moveDialog.value.show, (show) => {
    if (show) {
        chosen.value = null;
        openIds.value = [];
    }
});

const onSelect = (node) => {
    chosen.value = node.id;
};

const toggle = (id) => {
    const idx = openIds.value.indexOf(id);
    idx === -1 ? openIds.value.push(id) : openIds.value.splice(idx, 1);
};

const submit = () => {
    const cb = _moveDialog.value.onSubmit;
    const target = chosen.value;
    closeMoveDialog();
    if (cb) cb(target);
};
</script>
