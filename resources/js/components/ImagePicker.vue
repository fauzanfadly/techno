<template>
    <div>
        <v-container :style="{
            height: `${_props.height}px`,
            minHeight: `${_props.minHeight}px`,
            maxHeight: `${_props.maxHeight}px`,
        }" class="overflow-y-scroll">
            <v-row v-if="loading" justify="center">
                <v-col cols="auto">
                    <v-progress-circular
                        indeterminate
                        width="7"
                        color="deep-orange"
                    />
                </v-col>
            </v-row>
            <v-row
                v-else-if="items.length > 0"
                dense
            >
                <v-col
                    v-for="(item, index) in items"
                    :key="index"
                    sm="6"
                    md="3"
                    lg="3"
                >
                    <v-hover #="{ isHovering, props }">
                        <v-img
                            v-bind="props"
                            :src="getStorageFile(item.image_path)"
                            :height="_props.imageHeight"
                            cover
                            fluid
                            class="rounded-lg mb-1 border cursor-pointer"
                            @click="handleClickImage(item)"
                        >
                            <v-overlay
                                :model-value="!!isHovering"
                                class="align-center justify-center"
                                color="black"
                                opacity="0.3"
                                contained
                            ></v-overlay>
                        </v-img>
                        <p class="text-caption text-truncate">{{ item.name }}</p>
                    </v-hover>
                </v-col>
            </v-row>
            <v-row v-else>
                <v-col>
                    <p class="text-center">No images found, add image <span class="text-primary text-decoration-underline cursor-pointer" @click="navigateToCreateImage">here</span></p>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { Request } from '../utils/request';
import { getStorageFile } from '../utils/storage';
import { useRouter } from 'vue-router';


const router = useRouter();
const _props = defineProps({
    height: {
        type: [Number, String],
        default: null,
    },
    minHeight: {
        type: [Number, String],
        default: null,
    },
    maxHeight: {
        type: [Number, String],
        default: 700,
    },
    imageHeight: {
        type: [Number, String],
        default: 175,
    }
});


const items = ref([]);
const loading = ref(false);


const emit = defineEmits([
    'click:image',
]);


onMounted(async () => {
    await loadImages();
});


const handleClickImage = (image) => {
    return emit('click:image', image);
}

const loadImages = async () => {
    loading.value = true;
    await Request.get({
        url: `/api/assets-manager/image`,
        data: {
            page: 1,
            items_per_page: 30,
        },
        useLoading: false,
        errorMessage: "Failed when loading images"
    })
        .then(({ data }) => {
            items.value = data.data.data;
        })
        .finally(() => {
            loading.value = false;
        });
}

const navigateToCreateImage = () => {
    router.push({ name: "admin-assets-image-manager-create" });
}
</script>
