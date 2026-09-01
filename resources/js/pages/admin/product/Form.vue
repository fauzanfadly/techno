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
                                            <p v-if="paramId">Product</p>
                                            <p v-else>Create Product</p>
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
                                                @update:modelValue="fetchChilds"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                ref="vendorField"
                                                label="Vendor"
                                                v-model="form.mt_vendor_id"
                                                :items="optionValues.vendors"
                                                :rules="[v => !!v || 'Vendor is required']"
                                                :disabled="!form.mt_manufacture_type_id"
                                                return-object
                                                @update:modelValue="fetchChilds"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                ref="productCategoryField"
                                                label="Product Category"
                                                v-model="form.mt_product_category_id"
                                                :items="optionValues.productCategories"
                                                :rules="[v => !!v || 'Product Category is required']"
                                                :disabled="!form.mt_vendor_id"
                                                return-object
                                                @update:modelValue="fetchChilds"
                                            />
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                label="Product Series"
                                                v-model="form.mt_product_series_id"
                                                :items="optionValues.productSeries"
                                                :rules="[v => !!v || 'Product Series is required']"
                                                :disabled="!form.mt_product_category_id"
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
                                            <v-text-field
                                                label="PDF File"
                                                v-model="pdf.name"
                                                readonly
                                                placeholder="Pilih PDF (opsional)"
                                                @click="() => openFilePicker({ filter: 'pdf', onPick: onSelectPdf })"
                                                @focus="() => openFilePicker({ filter: 'pdf', onPick: onSelectPdf })"
                                            >
                                                <template #append-inner v-if="pdf.path">
                                                    <v-btn
                                                        icon
                                                        variant="text"
                                                        density="compact"
                                                        :href="getStorageFile(pdf.path)"
                                                        target="_blank"
                                                        @click.stop
                                                    ><v-icon>mdi-open-in-new</v-icon></v-btn>
                                                </template>
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-textarea
                                                label="Description"
                                                v-model="form.description"
                                                variant="outlined"
                                                density="compact"
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
const vendorField = useTemplateRef('vendorField');
const productCategoryField = useTemplateRef('productCategoryField');
const valid = ref(false);
const form = ref({
    name: '',
    description: '',
    image_id: null,
    file_id: null,
    mt_manufacture_type_id: null,
    mt_vendor_id: null,
    mt_product_category_id: null,
    mt_product_series_id: null,
});
const optionValues = ref({
    manufactureTypes: [],
    vendors: [],
    productCategories: [],
    productSeries: [],
});
const paramId = ref(null);
const image = ref({
    name: null,
    path: null,
});
const pdf = ref({
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


const onSelectImage = (value) => {
    if (!value) {
        return;
    }
    form.value.image_id = value.id;
    image.value.name = value.name;
    image.value.path = value.file_path;
}

const onSelectPdf = (value) => {
    if (!value) {
        return;
    }
    form.value.file_id = value.id;
    pdf.value.name = value.name;
    pdf.value.path = value.file_path;
}

const fetchManufactureTypes = async () => {
    optionValues.value.manufactureTypes = await fetchServices.listOfValue({
        url: '/api/manufacture-type',
        titleKey: 'name',
        valueKey: 'id',
    });
}

const fetchChilds = (value) => {
    let valueKey = "";
    let formIdKey = "";
    let optionKey = "";

    if (value.data.mt_vendor) {
        valueKey = "mt_vendor";
        formIdKey = "mt_vendor_id";
        optionKey = "vendors";
    } else if (value.data.mt_product_category) {
        valueKey = "mt_product_category";
        formIdKey = "mt_product_category_id";
        optionKey = "productCategories";
    } else if (value.data.mt_product_series) {
        valueKey = "mt_product_series";
        formIdKey = "mt_product_series_id";
        optionKey = "productSeries";
    }

    const _items = collect(value.data[valueKey]);
    optionValues.value[optionKey] = fetchServices.generateListOfValue({
        items: _items.get(),
        valueKey: 'id',
        titleKey: 'name',
    });
    form.value[formIdKey] = !!(_items.find('id', form.value[formIdKey]))
        ? form.value[formIdKey]
        : null;
}

const fetchDetail = async (id) => {
    await Request.get({
        url: `/api/product/detail/${id}`,
        errorMessage: `Failed when fetching product "${id}"`,
        useLoading: true,
    })
        .then(({ data }) => {
            const _productSeries = data.data.mt_product_series;
            const _productCategoryId = _productSeries.mt_product_category.id;
            const _vendorId = _productSeries.mt_product_category.mt_vendor.id;
            const _manufactureTypeId = _productSeries.mt_product_category.mt_vendor.mt_manufacture_type.id;
            const _image = data.data.image;
            const _file = data.data.file;

            form.value.name = data.data.name;
            form.value.description = data.data.description;
            form.value.mt_manufacture_type_id = _manufactureTypeId;
            form.value.mt_vendor_id = _vendorId;
            form.value.mt_product_category_id = _productCategoryId;
            form.value.mt_product_series_id = _productSeries.id;

            const _manufactureType = collect(optionValues.value.manufactureTypes).find('value', _manufactureTypeId);
            manufactureTypeField.value.$emit('update:modelValue', _manufactureType);

            const _vendor = collect(optionValues.value.vendors).find('value', _vendorId);
            vendorField.value.$emit('update:modelValue', _vendor);

            const _productCategory = collect(optionValues.value.vendors).find('value', _productCategoryId);
            productCategoryField.value.$emit('update:modelValue', _productCategory);

            onSelectImage(_image);
            onSelectPdf(_file);
        });
}

const submitForm = async () => {
    if (!valid.value) {
        return;
    }

    let url = "/api/product/create";
    let errorMessage = "Failed when creating product";
    if (paramId.value) {
        url = `/api/product/update/${paramId.value}`;
        errorMessage = `Failed when updating product "${paramId.value}"`;
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
                    message: data.message || "Product created successfully",
                    status: "success",
                });
            }, 10);
        });
};
</script>
