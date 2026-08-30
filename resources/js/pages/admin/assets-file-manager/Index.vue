<template>
    <div>
        <dashboard-layout>
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <p class="text-h5">Assets Manager</p>
                        <v-divider class="mt-2"></v-divider>
                    </v-col>
                </v-row>

                <v-row>
                    <!-- LEFT: folder tree -->
                    <v-col cols="12" md="4" lg="3">
                        <v-card>
                            <v-card-title class="d-flex align-center py-2">
                                <span class="text-subtitle-1">Folders</span>
                                <v-spacer></v-spacer>
                                <v-btn
                                    size="small"
                                    variant="text"
                                    icon="mdi-folder-plus-outline"
                                    :title="selectedFolder ? `Subfolder di ${selectedFolder.name}` : 'Folder baru di root'"
                                    @click="newFolder"
                                ></v-btn>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-text style="max-height: 65vh; overflow-y: auto;">
                                <div
                                    class="folder-node d-flex align-center"
                                    :class="{ 'folder-selected': selectedFolder === null }"
                                    @click="selectRoot"
                                >
                                    <v-icon size="18" color="amber-darken-2" class="mr-1">mdi-home</v-icon>
                                    <span class="folder-name">Root</span>
                                </div>
                                <folder-tree
                                    :nodes="tree"
                                    :selected-id="selectedFolder ? selectedFolder.id : null"
                                    :open-ids="openIds"
                                    @select="selectFolder"
                                    @toggle="toggle"
                                ></folder-tree>
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <!-- RIGHT: files -->
                    <v-col cols="12" md="8" lg="9">
                        <v-card>
                            <v-card-title class="d-flex align-center flex-wrap py-2">
                                <v-icon class="mr-2" color="amber-darken-2">mdi-folder-open</v-icon>
                                <span class="text-subtitle-1">{{ breadcrumb }}</span>
                                <v-spacer></v-spacer>
                                <template v-if="selectedFolder">
                                    <v-btn size="small" variant="text" icon="mdi-rename-box" title="Rename folder" @click="renameFolder"></v-btn>
                                    <v-btn size="small" variant="text" icon="mdi-folder-move-outline" title="Pindah folder" @click="moveFolder"></v-btn>
                                    <v-btn size="small" variant="text" icon="mdi-delete-outline" color="red" title="Hapus folder" @click="deleteFolder"></v-btn>
                                </template>
                                <v-btn size="small" color="deep-orange" class="ml-2" prepend-icon="mdi-upload" @click="upload">Upload</v-btn>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-text style="min-height: 40vh;">
                                <div v-if="loadingFiles" class="d-flex justify-center py-10">
                                    <v-progress-circular indeterminate color="deep-orange"></v-progress-circular>
                                </div>
                                <div v-else-if="files.length === 0" class="text-center text-grey py-10">
                                    <v-icon size="48" color="grey-lighten-1">mdi-folder-open-outline</v-icon>
                                    <p class="mt-2">Folder ini kosong</p>
                                </div>
                                <v-row v-else>
                                    <v-col
                                        v-for="file in files"
                                        :key="file.id"
                                        cols="6" sm="4" md="3" lg="2"
                                    >
                                        <v-card variant="outlined" class="file-card">
                                            <div class="file-thumb" @click="isImage(file) && preview(file)">
                                                <v-img
                                                    v-if="isImage(file)"
                                                    :src="getStorageFile(file.file_path)"
                                                    height="110"
                                                    cover
                                                ></v-img>
                                                <div v-else class="d-flex align-center justify-center" style="height: 110px;">
                                                    <v-icon size="48" :color="iconColor(file)">{{ fileIcon(file) }}</v-icon>
                                                </div>
                                            </div>
                                            <div class="d-flex align-center px-2 py-1">
                                                <span class="file-name text-caption text-truncate" :title="file.name">{{ file.name }}</span>
                                                <v-spacer></v-spacer>
                                                <v-menu>
                                                    <template #activator="{ props }">
                                                        <v-btn size="x-small" variant="text" icon="mdi-dots-vertical" v-bind="props"></v-btn>
                                                    </template>
                                                    <v-list density="compact">
                                                        <v-list-item v-if="isImage(file)" prepend-icon="mdi-fullscreen" title="Preview" @click="preview(file)"></v-list-item>
                                                        <v-list-item prepend-icon="mdi-rename-box" title="Rename" @click="renameFile(file)"></v-list-item>
                                                        <v-list-item prepend-icon="mdi-file-move-outline" title="Pindah" @click="moveFile(file)"></v-list-item>
                                                        <v-list-item prepend-icon="mdi-swap-horizontal" title="Ganti file" @click="replaceFile(file)"></v-list-item>
                                                        <v-list-item prepend-icon="mdi-delete-outline" title="Hapus" base-color="red" @click="deleteFile(file)"></v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </div>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </dashboard-layout>

        <name-prompt-dialog></name-prompt-dialog>
        <move-dialog></move-dialog>
        <file-upload-dialog></file-upload-dialog>
        <image-full-screen-dialog></image-full-screen-dialog>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { Request } from '../../../utils/request';
import { getStorageFile } from '../../../utils/storage';
import { openSnackbar } from '../../../utils/snackbar';
import { openMessage } from '../../../utils/message_dialog';
import { openNamePrompt } from '../../../utils/name_prompt_dialog';
import { openMoveDialog } from '../../../utils/move_dialog';
import { openUploadDialog } from '../../../utils/file_upload_dialog';
import { openImageFullscreen } from '../../../utils/image_full_screen_dialog';
import FolderTree from '../../../components/asset-manager/FolderTree.vue';
import NamePromptDialog from '../../../components/dialogs/NamePromptDialog.vue';
import MoveDialog from '../../../components/dialogs/MoveDialog.vue';
import FileUploadDialog from '../../../components/dialogs/FileUploadDialog.vue';
import ImageFullScreenDialog from '../../../components/dialogs/ImageFullScreenDialog.vue';

const folders = ref([]);
const tree = ref([]);
const openIds = ref([]);
const selectedFolder = ref(null); // null = root
const files = ref([]);
const loadingFiles = ref(false);

const buildTree = (list) => {
    const byId = {};
    list.forEach((f) => { byId[f.id] = { ...f, children: [] }; });
    const roots = [];
    list.forEach((f) => {
        if (f.parent_id && byId[f.parent_id]) {
            byId[f.parent_id].children.push(byId[f.id]);
        } else {
            roots.push(byId[f.id]);
        }
    });
    return roots;
};

const breadcrumb = computed(() => {
    if (!selectedFolder.value) return 'Root';
    return 'Root / ' + selectedFolder.value.path.split('/').join(' / ');
});

onMounted(async () => {
    await loadFolders();
    await loadFiles();
});

const loadFolders = async () => {
    try {
        const { data } = await Request.get({ url: '/api/assets-manager/folder', errorMessage: 'Gagal memuat folder' });
        folders.value = data.data || [];
        tree.value = buildTree(folders.value);
    } catch (e) { /* handled by Request */ }
};

const loadFiles = async () => {
    loadingFiles.value = true;
    try {
        const { data } = await Request.get({
            url: '/api/assets-manager/file',
            data: { folder_id: selectedFolder.value ? selectedFolder.value.id : '' },
            errorMessage: 'Gagal memuat file',
        });
        files.value = data.data || [];
    } catch (e) { /* handled */ } finally {
        loadingFiles.value = false;
    }
};

const selectFolder = (node) => {
    selectedFolder.value = node;
    loadFiles();
};

const selectRoot = () => {
    selectedFolder.value = null;
    loadFiles();
};

const toggle = (id) => {
    const i = openIds.value.indexOf(id);
    i === -1 ? openIds.value.push(id) : openIds.value.splice(i, 1);
};

const ensureOpen = (id) => { if (!openIds.value.includes(id)) openIds.value.push(id); };

// Setelah reload folder, refresh objek selectedFolder (path bisa berubah)
const syncSelected = () => {
    if (!selectedFolder.value) return;
    selectedFolder.value = folders.value.find((f) => f.id === selectedFolder.value.id) || null;
};

const newFolder = () => {
    const parent = selectedFolder.value;
    openNamePrompt({
        title: parent ? `Folder baru di "${parent.name}"` : 'Folder baru (root)',
        label: 'Nama folder',
        confirmText: 'Buat',
        onSubmit: async (name) => {
            try {
                await Request.post({
                    url: '/api/assets-manager/folder/create',
                    data: { name, parent_id: parent ? parent.id : null },
                    useLoading: true,
                    errorMessage: 'Gagal membuat folder',
                });
                openSnackbar({ message: 'Folder dibuat', status: 'success' });
                if (parent) ensureOpen(parent.id);
                await loadFolders();
            } catch (e) { /* handled */ }
        },
    });
};

const renameFolder = () => {
    const f = selectedFolder.value;
    if (!f) return;
    openNamePrompt({
        title: 'Rename folder', label: 'Nama folder', name: f.name,
        onSubmit: async (name) => {
            try {
                await Request.post({ url: `/api/assets-manager/folder/update/${f.id}`, data: { name }, useLoading: true, errorMessage: 'Gagal rename folder' });
                openSnackbar({ message: 'Folder di-rename', status: 'success' });
                await loadFolders();
                syncSelected();
                await loadFiles();
            } catch (e) { /* handled */ }
        },
    });
};

const moveFolder = () => {
    const f = selectedFolder.value;
    if (!f) return;
    openMoveDialog({
        title: `Pindahkan "${f.name}"`, nodes: tree.value, excludeId: f.id,
        onSubmit: async (targetId) => {
            try {
                await Request.post({ url: `/api/assets-manager/folder/update/${f.id}`, data: { parent_id: targetId }, useLoading: true, errorMessage: 'Gagal memindah folder' });
                openSnackbar({ message: 'Folder dipindah', status: 'success' });
                await loadFolders();
                syncSelected();
                await loadFiles();
            } catch (e) { /* handled */ }
        },
    });
};

const deleteFolder = () => {
    const f = selectedFolder.value;
    if (!f) return;
    openMessage({
        message: 'Hapus Folder',
        description: `Yakin hapus "${f.name}" beserta semua subfolder & file di dalamnya? Tindakan ini permanen.`,
        icon: 'mdi-delete-alert', iconColor: 'red',
        actionButtons: [
            { color: 'gray', text: 'Batal' },
            {
                color: 'red', text: 'Hapus', action: async () => {
                    try {
                        await Request.del({ url: `/api/assets-manager/folder/delete/${f.id}`, useLoading: true, errorMessage: 'Gagal menghapus folder' });
                        openSnackbar({ message: 'Folder dihapus', status: 'success' });
                        selectedFolder.value = null;
                        await loadFolders();
                        await loadFiles();
                    } catch (e) { /* handled */ }
                },
            },
        ],
    });
};

const upload = () => {
    openUploadDialog({
        mode: 'create',
        onSubmit: async ({ file, name, description }) => {
            const fd = new FormData();
            fd.append('name', name || file.name);
            if (description) fd.append('description', description);
            if (selectedFolder.value) fd.append('folder_id', selectedFolder.value.id);
            fd.append('file', file);
            try {
                await Request.post({ url: '/api/assets-manager/file/create', data: fd, useLoading: true, errorMessage: 'Gagal upload file' });
                openSnackbar({ message: 'File diupload', status: 'success' });
                await loadFiles();
                await loadFolders();
            } catch (e) { /* handled */ }
        },
    });
};

const renameFile = (file) => {
    openNamePrompt({
        title: 'Rename file', label: 'Nama', name: file.name,
        onSubmit: async (name) => {
            try {
                await Request.post({ url: `/api/assets-manager/file/update/${file.id}`, data: { name }, useLoading: true, errorMessage: 'Gagal rename file' });
                openSnackbar({ message: 'File di-rename', status: 'success' });
                await loadFiles();
            } catch (e) { /* handled */ }
        },
    });
};

const moveFile = (file) => {
    openMoveDialog({
        title: `Pindahkan "${file.name}"`, nodes: tree.value, excludeId: null,
        onSubmit: async (targetId) => {
            try {
                await Request.post({ url: `/api/assets-manager/file/update/${file.id}`, data: { folder_id: targetId }, useLoading: true, errorMessage: 'Gagal memindah file' });
                openSnackbar({ message: 'File dipindah', status: 'success' });
                await loadFiles();
                await loadFolders();
            } catch (e) { /* handled */ }
        },
    });
};

const replaceFile = (file) => {
    openUploadDialog({
        mode: 'replace',
        onSubmit: async ({ file: newFile }) => {
            const fd = new FormData();
            fd.append('file', newFile);
            try {
                await Request.post({ url: `/api/assets-manager/file/update/${file.id}`, data: fd, useLoading: true, errorMessage: 'Gagal mengganti file' });
                openSnackbar({ message: 'File diganti', status: 'success' });
                await loadFiles();
            } catch (e) { /* handled */ }
        },
    });
};

const deleteFile = (file) => {
    openMessage({
        message: 'Hapus File',
        description: `Yakin hapus "${file.name}"? Jika file ini terpasang di produk, referensinya akan dilepas.`,
        icon: 'mdi-delete-alert', iconColor: 'red',
        actionButtons: [
            { color: 'gray', text: 'Batal' },
            {
                color: 'red', text: 'Hapus', action: async () => {
                    try {
                        await Request.del({ url: `/api/assets-manager/file/delete/${file.id}`, useLoading: true, errorMessage: 'Gagal menghapus file' });
                        openSnackbar({ message: 'File dihapus', status: 'success' });
                        await loadFiles();
                        await loadFolders();
                    } catch (e) { /* handled */ }
                },
            },
        ],
    });
};

const preview = (file) => openImageFullscreen(file.file_path);

const isImage = (file) => (file.file_mime_type || '').startsWith('image/');

const fileIcon = (file) => {
    const ext = (file.file_extension || '').toLowerCase();
    if (ext === 'pdf') return 'mdi-file-pdf-box';
    if (['doc', 'docx'].includes(ext)) return 'mdi-file-word-box';
    if (['xls', 'xlsx', 'csv'].includes(ext)) return 'mdi-file-excel-box';
    if (['ppt', 'pptx'].includes(ext)) return 'mdi-file-powerpoint-box';
    if (ext === 'txt') return 'mdi-file-document-outline';
    return 'mdi-file-outline';
};

const iconColor = (file) => {
    const ext = (file.file_extension || '').toLowerCase();
    if (ext === 'pdf') return 'red';
    if (['doc', 'docx'].includes(ext)) return 'blue';
    if (['xls', 'xlsx', 'csv'].includes(ext)) return 'green';
    if (['ppt', 'pptx'].includes(ext)) return 'orange';
    return 'grey';
};
</script>

<style scoped>
.folder-node {
    cursor: pointer;
    border-radius: 4px;
    padding: 4px;
}
.folder-node:hover {
    background: rgba(0, 0, 0, 0.04);
}
.folder-selected {
    background: rgba(255, 87, 34, 0.12);
}
.folder-name {
    font-size: 0.875rem;
}
.file-card {
    overflow: hidden;
}
.file-thumb {
    cursor: pointer;
    background: #fafafa;
}
.file-name {
    max-width: 70%;
}
</style>
