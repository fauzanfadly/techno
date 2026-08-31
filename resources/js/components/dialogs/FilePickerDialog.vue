<template>
    <v-dialog v-model="_filePicker.show" max-width="820" scrollable>
        <v-card>
            <v-card-title class="d-flex align-center py-2">
                <span class="text-subtitle-1">
                    {{ _filePicker.filter === 'pdf' ? 'Pilih Dokumen/PDF' : (_filePicker.filter === 'image' ? 'Pilih Gambar' : 'Pilih File') }}
                </span>
                <v-spacer></v-spacer>
                <v-btn icon="mdi-close" variant="text" density="compact" @click="closeFilePicker"></v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text style="height: 60vh;">
                <v-row no-gutters style="height: 100%;">
                    <!-- Folder tree -->
                    <v-col cols="4" class="pr-2" style="height: 100%; overflow-y: auto; border-right: 1px solid rgba(0,0,0,0.08);">
                        <div
                            class="folder-node d-flex align-center"
                            :class="{ 'folder-selected': selectedFolder === null }"
                            @click="selectRoot"
                        >
                            <v-icon size="18" color="amber-darken-2" class="mr-1">mdi-home</v-icon>
                            <span style="font-size: 0.875rem;">Root</span>
                        </div>
                        <folder-tree
                            :nodes="tree"
                            :selected-id="selectedFolder ? selectedFolder.id : null"
                            :open-ids="openIds"
                            @select="selectFolder"
                            @toggle="toggle"
                        ></folder-tree>
                    </v-col>

                    <!-- File grid -->
                    <v-col cols="8" class="pl-2" style="height: 100%; overflow-y: auto;">
                        <div v-if="loading" class="d-flex justify-center py-8">
                            <v-progress-circular indeterminate color="deep-orange"></v-progress-circular>
                        </div>
                        <div v-else-if="visibleFiles.length === 0" class="text-center text-grey py-8">
                            Tidak ada file di folder ini
                        </div>
                        <v-row v-else>
                            <v-col v-for="file in visibleFiles" :key="file.id" cols="4" sm="3">
                                <v-card variant="outlined" class="pick-card" @click="pick(file)">
                                    <v-img
                                        v-if="isImage(file)"
                                        :src="getStorageFile(file.file_path)"
                                        height="80"
                                        cover
                                    ></v-img>
                                    <div v-else class="d-flex align-center justify-center" style="height: 80px;">
                                        <v-icon size="36" :color="iconColor(file)">{{ fileIcon(file) }}</v-icon>
                                    </div>
                                    <div class="text-caption text-truncate px-1 py-1" :title="file.name">{{ file.name }}</div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { Request } from '../../utils/request';
import { getStorageFile } from '../../utils/storage';
import { _filePicker, closeFilePicker } from '../../utils/file_picker_dialog';
import FolderTree from '../asset-manager/FolderTree.vue';

const tree = ref([]);
const openIds = ref([]);
const selectedFolder = ref(null);
const files = ref([]);
const loading = ref(false);
let loadedFolders = false;

watch(() => _filePicker.value.show, (show) => {
    if (show) {
        selectedFolder.value = null;
        if (!loadedFolders) loadFolders();
        loadFiles();
    }
});

const buildTree = (list) => {
    const byId = {};
    list.forEach((f) => { byId[f.id] = { ...f, children: [] }; });
    const roots = [];
    list.forEach((f) => {
        if (f.parent_id && byId[f.parent_id]) byId[f.parent_id].children.push(byId[f.id]);
        else roots.push(byId[f.id]);
    });
    return roots;
};

const loadFolders = async () => {
    try {
        const { data } = await Request.get({ url: '/api/assets-manager/folder', errorMessage: 'Gagal memuat folder' });
        tree.value = buildTree(data.data || []);
        loadedFolders = true;
    } catch (e) { /* handled */ }
};

const loadFiles = async () => {
    loading.value = true;
    try {
        const { data } = await Request.get({
            url: '/api/assets-manager/file',
            data: { folder_id: selectedFolder.value ? selectedFolder.value.id : '' },
            errorMessage: 'Gagal memuat file',
        });
        files.value = data.data || [];
    } catch (e) { /* handled */ } finally {
        loading.value = false;
    }
};

const selectFolder = (node) => { selectedFolder.value = node; loadFiles(); };
const selectRoot = () => { selectedFolder.value = null; loadFiles(); };
const toggle = (id) => {
    const i = openIds.value.indexOf(id);
    i === -1 ? openIds.value.push(id) : openIds.value.splice(i, 1);
};

const isImage = (file) => (file.file_mime_type || '').startsWith('image/');
const isPdf = (file) => (file.file_extension || '').toLowerCase() === 'pdf';

const visibleFiles = computed(() => {
    const filter = _filePicker.value.filter;
    if (filter === 'image') return files.value.filter(isImage);
    if (filter === 'pdf') return files.value.filter((f) => !isImage(f)); // dokumen/pdf
    return files.value;
});

const pick = (file) => {
    const cb = _filePicker.value.onPick;
    closeFilePicker();
    if (cb) cb(file);
};

const fileIcon = (file) => {
    const ext = (file.file_extension || '').toLowerCase();
    if (ext === 'pdf') return 'mdi-file-pdf-box';
    if (['doc', 'docx'].includes(ext)) return 'mdi-file-word-box';
    if (['xls', 'xlsx', 'csv'].includes(ext)) return 'mdi-file-excel-box';
    if (['ppt', 'pptx'].includes(ext)) return 'mdi-file-powerpoint-box';
    return 'mdi-file-outline';
};
const iconColor = (file) => {
    const ext = (file.file_extension || '').toLowerCase();
    if (ext === 'pdf') return 'red';
    if (['doc', 'docx'].includes(ext)) return 'blue';
    if (['xls', 'xlsx', 'csv'].includes(ext)) return 'green';
    return 'grey';
};
</script>

<style scoped>
.folder-node {
    cursor: pointer;
    border-radius: 4px;
    padding: 4px;
}
.folder-node:hover { background: rgba(0, 0, 0, 0.04); }
.folder-selected { background: rgba(255, 87, 34, 0.12); }
.pick-card { cursor: pointer; overflow: hidden; }
.pick-card:hover { border-color: #ff5722; }
</style>
