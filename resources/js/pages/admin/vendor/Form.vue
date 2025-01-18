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
                                            <p v-if="paramId">Vendor</p>
                                            <p v-else>Create Vendor</p>
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-divider></v-divider>
                                        <v-col md="6">
                                            <v-text-field
                                                label="Name"
                                                v-model="form.name"
                                                :rules="[v => !!v || 'Name is required']"
                                            />
                                        </v-col>
                                        <v-col md="6">
                                            <v-autocomplete
                                                label="Manufacture Type"
                                                v-model="form.mt_manufacture_type_id"
                                                :items="optionValues.manufactureTypes"
                                                :rules="[v => !!v || 'Manufacture Type is required']"
                                            />
                                        </v-col>
                                        <v-col cols="auto">
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
                                        <v-col md="5" align-self="end">
                                            <v-text-field
                                                label="Image File"
                                                v-model="image.name"
                                                @click="() => openSelectImageDialog()"
                                                @focus="() => openSelectImageDialog()"
                                            />
                                            <SelectFileImageDialog
                                                @click:image="onSelectImage"
                                            ></SelectFileImageDialog>
                                        </v-col>
                                        <v-col md="12">
                                            <v-textarea
                                                label="Description"
                                                v-model="form.description"
                                                variant="outlined"
                                                density="compact"
                                            />
                                        </v-col>
                                        <v-col md="12">
                                            <v-btn
                                                type="submit"
                                                color="primary"
                                            >
                                                Submit
                                            </v-btn>
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
import { useUserStore } from '../../../store/user';
import { Request } from '../../../utils/request';
import { getStorageFile } from '../../../utils/storage';
import { openImageFullscreen } from '../../../utils/image_full_screen_dialog';
import { openSelectImageDialog } from '../../../utils/select_file_image_dialog';
import SelectFileImageDialog from '../../../components/dialogs/SelectFileImageDialog.vue';
import { fetchServices } from '../../../utils/fetch_services';


const router = useRouter();
const userStore = useUserStore();
const valid = ref(false);
const form = ref({
    name: null,
    description: null,
    mt_manufacture_type_id: null,
    image_id: null,
});
const optionValues = ref({
    manufactureTypes: []
});
const paramId = ref(null);
const image = ref({
    name: null,
    path: null,
});


onMounted(async () => {
    await fetchManufactureTypes();

    paramId.value = router.currentRoute.value.params.id || null;
    if (paramId.value) {
        await fetchDetail(paramId.value);
    }
});


const fetchManufactureTypes = async () => {
    optionValues.value.manufactureTypes = await fetchServices.listOfValue({
        url: '/api/manufacture-type',
        titleKey: 'name',
        valueKey: 'id',
    });
}


const fetchDetail = async (id) => {
    await Request.get({
        url: `/api/vendor/detail/${id}`,
        errorMessage: `Failed when fetching vendor "${id}"`,
        useLoading: true,
    })
        .then(({ data }) => {
            form.value.name = data.data.name;
            form.value.description = data.data.description;
            form.value.mt_manufacture_type_id = data.data.mt_manufacture_type_id;
            form.value.image_id = data.data.image.id;
            onSelectImage(data.data.image);
        });
}

const onSelectImage = (value) => {
    form.value.image_id = value.id;
    image.value.name = value.name;
    image.value.path = value.image_path;
}

const submitForm = async () => {
    if (!valid.value) {
        return;
    }

    let url = "/api/vendor/create";
    let errorMessage = "Failed when creating vendor";
    if (paramId.value) {
        url = `/api/vendor/update/${paramId.value}`;
        errorMessage = `Failed when updating vendor "${paramId.value}"`;
    }

    await Request.post({
        url,
        data: form.value,
        errorMessage,
        useLoading: true,
    })
        .then(({ data }) => {
            router.back();
            setTimeout(() => {
                openSnackbar({
                    message: data.message || "Vendor created successfully",
                    status: "success",
                });
            }, 10);
        });
};
</script>
