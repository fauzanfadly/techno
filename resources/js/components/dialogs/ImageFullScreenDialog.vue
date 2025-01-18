<template>
    <v-dialog
        v-model="_props.show"
        app
        @click="() => _props.show = false"
    >
        <v-container>
            <v-row justify="center">
                <v-col cols="auto">
                    <v-img
                        v-if="_props.imageSrc"
                        :width="_props.imageWidth"
                        :height="_props.imageHeight"
                        max-height="80vh"
                        :src="_props.imageSrc"
                    ></v-img>
                    <v-card v-else class="pa-3">
                        <v-icon size="200" color="grey">mdi-image-off-outline</v-icon>
                        <p>Image not available</p>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-dialog>
</template>

<script setup>
import { _props } from "../../utils/image_full_screen_dialog";
import { getStorageFile } from "../../utils/storage";
</script>
