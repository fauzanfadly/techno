<template>
    <div>
        <dashboard-layout>
            <v-container>
                <v-row>
                    <v-col md="12">
                        <v-form
                            v-model="valid"
                            lazy-validation
                            @submit.prevent="submitForm"
                        >
                            <v-card>
                                <v-container>
                                    <v-row>
                                        <v-col md="auto" align-self="center">
                                            <v-btn
                                                icon
                                                variant="text"
                                                density="compact"
                                                @click="() => $router.back()"
                                            >
                                                <v-icon>mdi-chevron-left</v-icon>
                                            </v-btn>
                                        </v-col>
                                        <v-col md="auto" class="text-h5">
                                            <p v-if="paramId">Image</p>
                                            <p v-else>Create Image</p>
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-divider></v-divider>
                                        <v-col
                                            v-if="paramId !== null"
                                            cols="12"
                                        >
                                            <v-img
                                                v-if="image.path"
                                                width="200"
                                                height="200"
                                                cover
                                                :src="getStorageFile(image.path)"
                                                class="rounded-lg border-sm"
                                            >
                                                <v-btn
                                                    class="rounded-0 position-absolute bottom-0 right-0 pa-1 w-fit"
                                                    varian="outlined"
                                                    density="compact"
                                                    @click="() => openImageFullscreen(image.path)"
                                                ><v-icon>mdi-fullscreen</v-icon></v-btn>
                                            </v-img>
                                            <v-icon
                                                v-else
                                                size="200"
                                                color="grey"
                                            >
                                                mdi-image-off-outline
                                            </v-icon>
                                        </v-col>
                                        <v-col md="6">
                                            <v-text-field
                                                label="Name"
                                                v-model="form.name"
                                                :rules="[v => !!v || 'Name is required']"
                                            />
                                        </v-col>
                                        <v-col v-if="!paramId" md="6">
                                            <v-file-input
                                                label="Image File"
                                                v-model="form.image_file"
                                                accept=".jpg,.jpeg,.png"
                                                :rules="[v => !!v || 'Image is required']"
                                            />
                                        </v-col>
                                        <v-col md="12">
                                            <v-textarea
                                                label="Description"
                                                v-model="form.description"
                                                variant="outlined"
                                                density="compact"
                                            />
                                        </v-col>
                                        <v-col cols="auto">
                                            <v-btn
                                                type="submit"
                                                color="primary"
                                                v-text="'Submit'"
                                            />
                                        </v-col>
                                        <v-col v-if="paramId !== null" cols="auto">
                                            <v-btn
                                                :color="!items ? 'grey' : 'red'"
                                                v-text="'Delete'"
                                                :disabled="!items"
                                                @click="confirmDeleteItem(paramId)"
                                            />
                                        </v-col>
                                    </v-row>
                                    <v-divider v-if="paramId !== null" class="mt-5"></v-divider>
                                    <v-row v-if="paramId !== null">
                                        <v-col>
                                            <v-data-table-server
                                                v-model:items-per-page="itemsPerPage"
                                                :headers="headers"
                                                :items="items"
                                                :items-length="totalItems"
                                                :loading="loading"
                                                loading-text="Please wait, loading your data..."
                                            >
                                                <template #item.actions="{ item }">
                                                    <v-btn
                                                        color="red"
                                                        icon="mdi-trash-can"
                                                        variant="text"
                                                        density="compact"
                                                        @click="confirmRemoveItem(item.id, item.module_type)"
                                                    />
                                                </template>
                                            </v-data-table-server>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card>
                        </v-form>
                    </v-col>
                </v-row>
            </v-container>
        </dashboard-layout>
    </div>
</template>


<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { openSnackbar } from "../../../utils/snackbar";
import { openMessage } from "../../../utils/message_dialog";
import { useUserStore } from '../../../store/user';
import { Request } from '../../../utils/request';
import { getStorageFile } from '../../../utils/storage';
import { openLoading } from '../../../utils/loading_dialog';
import { openImageFullscreen } from '../../../utils/image_full_screen_dialog';


const router = useRouter();
const userStore = useUserStore();
const valid = ref(false);
const form = ref({
    name: '',
    description: '',
    image_file: null,
});
const paramId = ref(null);
const image = ref({
    name: null,
    path: null,
});
const headers = ref([
    {
        title: 'Name',
        key: 'name',
        width: '30%',
    },
    {
        title: 'Module Type',
        key: 'module_type',
    },
    {
        title: 'Actions',
        key: 'actions',
        width: '100px',
        sortable: false,
    },
]);
const loading = ref(true);
const totalItems = ref(0);
const items = ref([]);
const itemsPerPage = ref(30);
const modulesType = {
    'mt_product': 'Product',
    'mt_product_series': 'Product Series',
    'mt_product_category': 'Product Category',
    'mt_vendor': 'Vendor',
    'mt_manufacture_type': 'Manufacture Type',
}


onMounted(async () => {
    paramId.value = router.currentRoute.value.params.id || null;
    if (paramId.value) {
        await fetchDetail(paramId.value);
    }
});


const fetchDetail = async (id) => {
    loading.value = true;
    await Request.get({
        url: `/api/assets-manager/image/detail/${id}`,
        errorMessage: `Failed when fetching image "${id}"`,
        useLoading: true,
    })
        .then(({ data }) => {
            form.value.name = data.data.name;
            form.value.description = data.data.description;
            image.value.name = data.data.name;
            image.value.path = data.data.image_path;

            items.value = [];
            Object.keys(modulesType).map(type => {
                const moduleName = modulesType[type];
                (data.data[type] || []).map(item => items.value.push({
                    ...item, module_type: moduleName
                }));
            });
            totalItems.value = items.value.length;
        })
        .finally(() => {
            loading.value = false;
        });
};

const submitForm = async () => {
    if (!valid.value) {
        return;
    }

    let data = new FormData();
    Object.keys(form.value).map(field => {
        const value = form.value[field];

        if (field === 'image_file') {
            if (!value) {
                return null;
            }
        }

        data.append(field, value);
    });

    let url = "/api/assets-manager/image/create";
    let errorMessage = "Failed when creating image";
    if (paramId.value) {
        url = `/api/assets-manager/image/update/${paramId.value}`;
        errorMessage = `Failed when updating image "${paramId.value}"`;
        data = { name: form.value.name, description: form.value.description };
    }

    await Request.post({
        url,
        data,
        errorMessage,
        useLoading: true,
    })
        .then(({ data }) => {
            router.back();
            setTimeout(() => {
                openSnackbar({
                    message: data.message || "Image created successfully",
                    status: "success",
                });
            }, 10);
        });
};

const confirmRemoveItem = async (id, type) => {
    openMessage({
        description: `Are you sure you want to remove image from this ${type}?`,
        message: "Remove Image",
        icon: "mdi-delete-alert",
        iconColor: "red",
        actionButtons: [
            {
                color: "gray",
                text: "Cancel"
            },
            {
                color: "red",
                text: "Remove",
                action: () => {
                    removeItem(id, type);
                }
            }
        ]
    });
};

const removeItem = async (id, type) => {
    openLoading();
    await Request.del({
        url: `/api/assets-manager/image/remove/${paramId.value}`,
        data: {
            module_id: id,
            module_type: type,
        },
        errorMessage: `Failed to remove image`
    })
    .then(async () => {
        await fetchDetail(paramId.value);
    })
    .finally(() => {
        closeLoading();
    });
}

const confirmDeleteItem = async (id) => {
    openMessage({
        description: "Are you sure you want to delete this image?",
        message: "Delete Image",
        icon: "mdi-delete-alert",
        iconColor: "red",
        actionButtons: [
            {
                color: "gray",
                text: "Cancel"
            },
            {
                color: "red",
                text: "Delete",
                action: () => {
                    deleteItem(id);
                }
            }
        ]
    });
}

const deleteItem = async (id) => {
    openLoading();
    await Request.del({
        url: `/api/assets-manager/image/delete/${id}`,
        errorMessage: `Failed to delete image`
    })
    .then(async () => {
        await fetchDetail(paramId);
    })
    .finally(() => {
        closeLoading();
    });
}
</script>
