<template>
    <div>
        <v-dialog
            v-model="_dialogProps.show"
            max-width="600"
            class="dialog-wrapper"
        >
            <v-card class="pa-0 card-border" width="100%">
                <v-card-title>
                    <v-container class="pa-0">
                        <v-row no-gutters>
                            <v-col cols="auto">
                                {{ `Select ${_dialogProps.contentType === 'IMAGE' ? 'an image' : 'a file'}` }}
                            </v-col>
                            <v-spacer></v-spacer>
                            <v-col cols="auto">
                                <v-btn
                                    icon="mdi-close"
                                    variant="text"
                                    density="compact"
                                    @click="() => _dialogProps.show = false"
                                />
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-title>
                <v-divider></v-divider>
                <ImagePicker
                    image-height="100"
                    @click:image="selectImage"
                ></ImagePicker>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn
                        density="compact"
                        color="red"
                        @click="() => _dialogProps.show = false"
                    >
                        Cancel
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>


<script setup>
import { _dialogProps } from '../../utils/select_file_image_dialog';
import ImagePicker from '../ImagePicker.vue';


const emit = defineEmits([
    'click:image'
]);


const selectImage = (value) => {
    _dialogProps.value.show = false;
    emit('click:image', value);
}
</script>


<style scoped>
.dialog-wrapper .card-border {
    border: 1px solid var(--v-primary-base);
}

.dialog-wrapper p {
    margin: 0;
}
</style>
