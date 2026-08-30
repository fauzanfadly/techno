<template>
    <v-dialog v-model="_uploadDialog.show" max-width="480" persistent>
        <v-card>
            <v-card-title>{{ _uploadDialog.mode === 'replace' ? 'Ganti File' : 'Upload File' }}</v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-file-input
                    v-model="file"
                    label="Pilih file"
                    :accept="acceptTypes"
                    density="comfortable"
                    prepend-icon="mdi-paperclip"
                    show-size
                    @update:model-value="onPick"
                ></v-file-input>
                <v-text-field
                    v-if="_uploadDialog.mode === 'create'"
                    v-model="name"
                    label="Nama"
                    density="comfortable"
                ></v-text-field>
                <v-textarea
                    v-if="_uploadDialog.mode === 'create'"
                    v-model="description"
                    label="Deskripsi (opsional)"
                    rows="2"
                    density="comfortable"
                ></v-textarea>
                <p class="text-caption text-grey">
                    Gambar maks 10MB, dokumen maks 50MB. Tipe: jpg, jpeg, png, webp, gif, svg, pdf, doc(x), xls(x), ppt(x), txt, csv.
                </p>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="closeUploadDialog">Batal</v-btn>
                <v-btn color="deep-orange" :disabled="!file" @click="submit">
                    {{ _uploadDialog.mode === 'replace' ? 'Ganti' : 'Upload' }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, watch } from 'vue';
import { _uploadDialog, closeUploadDialog } from '../../utils/file_upload_dialog';

const acceptTypes = '.jpg,.jpeg,.png,.webp,.gif,.svg,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv';

const file = ref(null);
const name = ref('');
const description = ref('');

watch(() => _uploadDialog.value.show, (show) => {
    if (show) {
        file.value = null;
        name.value = '';
        description.value = '';
    }
});

// Vuetify 3 v-file-input model bisa File atau File[]
const pickedFile = () => (Array.isArray(file.value) ? file.value[0] : file.value);

const onPick = () => {
    const f = pickedFile();
    if (f && !name.value) {
        name.value = f.name.replace(/\.[^/.]+$/, '');
    }
};

const submit = () => {
    const f = pickedFile();
    if (!f) return;
    const cb = _uploadDialog.value.onSubmit;
    const payload = { file: f, name: name.value, description: description.value };
    closeUploadDialog();
    if (cb) cb(payload);
};
</script>
