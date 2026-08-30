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
                                    <v-row dense>
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
                                        <v-col class="text-h5">
                                            <p v-if="paramId">Product Category</p>
                                            <p v-else>Create Product Category</p>
                                        </v-col>
                                        <v-divider class="mb-5"></v-divider>
                                        <v-col cols="12">
                                            <v-text-field
                                                label="Name"
                                                v-model="form.name"
                                                :rules="[v => !!v || 'Name is required']"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                ref="manufactureTypeField"
                                                label="Manufacture Type"
                                                v-model="form.mt_manufacture_type_id"
                                                :items="optionValues.manufactureTypes"
                                                :rules="[v => !!v || 'Manufacture type is required']"
                                                return-object
                                                @update:modelValue="fetchVendors"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                label="Vendor"
                                                v-model="form.mt_vendor_id"
                                                :items="optionValues.vendors"
                                                :rules="[v => !!v || 'Vendor is required']"
                                                :disabled="!form.mt_manufacture_type_id"
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
                                        <v-col align-self="end">
                                            <v-text-field
                                                label="Image File"
                                                v-model="image.name"
                                                @click="() => openFilePicker({ filter: 'image', onPick: onSelectImage })"
                                                @focus="() => openFilePicker({ filter: 'image', onPick: onSelectImage })"
                                            />
                                            <FilePickerDialog
                                                
                                            ></FilePickerDialog>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-textarea
                                                label="Description"
                                                v-model="form.description"
                                                variant="outlined"
                                                density="compact"
                                                rows="3"
                                            />
                                        </v-col>
                                        <v-col cols="12">
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
import { onMounted, ref, useTemplateRef } from 'vue';
import { useRouter } from 'vue-router';
import { openSnackbar } from "../../../utils/snackbar";
import { useUserStore } from '../../../store/user';
import { Request } from '../../../utils/request';
import { getStorageFile } from '../../../utils/storage';
import { openImageFullscreen } from '../../../utils/image_full_screen_dialog';
import { openFilePicker } from '../../../utils/file_picker_dialog';
import FilePickerDialog from '../../../components/dialogs/FilePickerDialog.vue';
import { fetchServices } from '../../../utils/fetch_services';
import { collect } from '../../../utils/collection';


const router = useRouter();
const userStore = useUserStore();
const manufactureTypeField = useTemplateRef('manufactureTypeField');
const valid = ref(false);
const form = ref({
    name: null,
    description: null,
    mt_manufacture_type_id: null,
    mt_vendor_id: null,
    image_id: null,
});
const optionValues = ref({
    manufactureTypes: [],
    vendors: [],
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

const fetchVendors = (value) => {
    const _items = collect(value.data.mt_vendor);
    const _vendorId = form.value.mt_vendor_id;

    optionValues.value.vendors = fetchServices.generateListOfValue({
        items: _items.get(),
        valueKey: 'id',
        titleKey: 'name',
    });
    form.value.mt_vendor_id = !!(_items.find('id', _vendorId)) ? _vendorId : null;
}

const fetchDetail = async (id) => {
    await Request.get({
        url: `/api/product/category/detail/${id}`,
        errorMessage: `Failed when fetching product category "${id}"`,
        useLoading: true,
    })
        .then(({ data }) => {
            const _vendor = data.data.mt_vendor;
            const _manufactureTypeId = _vendor.mt_manufacture_type.id;
            const _image = data.data.image;

            form.value.name = data.data.name;
            form.value.description = data.data.description;
            form.value.mt_manufacture_type_id = _manufactureTypeId;
            form.value.mt_vendor_id = _vendor.id;

            const _manufactureType = collect(optionValues.value.manufactureTypes).find('value', _manufactureTypeId);
            manufactureTypeField.value.$emit('update:modelValue', _manufactureType);

            onSelectImage(_image);
        });
}

const onSelectImage = (value) => {
    form.value.image_id = value.id;
    image.value.name = value.name;
    image.value.path = value.file_path;
}

const submitForm = async () => {
    if (!valid.value) {
        return;
    }

    let url = "/api/product/category/create";
    let errorMessage = "Failed when creating product category";
    if (paramId.value) {
        url = `/api/product/category/update/${paramId.value}`;
        errorMessage = `Failed when updating product category "${paramId.value}"`;
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
                    message: data.message || "Product category created successfully",
                    status: "success",
                });
            }, 10);
        });
};
</script>
