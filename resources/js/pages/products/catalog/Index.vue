<template>
    <landing-page-layout id="pages-products-catalog-index">
        <v-container class="py-15 pb-15">
            <v-row class="mt-5">
                <v-col cols="auto" class="pa-0">
                    <v-btn
                        variant="text"
                        class="text-h6 font-weight-regular"
                        rounded="lg"
                        :to="`/product/${manufactureType.name}`"
                    >
                        <v-icon class="me-2">mdi-chevron-left</v-icon>Back to {{ manufactureType.name }}
                    </v-btn>
                </v-col>
            </v-row>
            <v-row class="mt-5">
                <v-col md="4">
                    <v-autocomplete
                        v-model="selectVendor"
                        density="compact"
                        variant="outlined"
                        label="Distributor"
                        :items="manufactureType.mt_vendor"
                        item-title="name"
                        item-value="name"
                        return-object
                        hide-details=""
                        @update:modelValue="changeVendor"
                    />
                </v-col>
            </v-row>
            <v-divider class="my-5"></v-divider>
            <v-row>
                <v-col cols="auto" align-self="center" v-if="!!vendor">
                    <v-img
                        :src="`${rawStorage.vendorImg({
                            manufactureId: vendor.mt_manufacture_type_id,
                            vendorId: vendor.id,
                        })}.png`"
                        width="100"
                        height="30"
                    >
                    </v-img>
                </v-col>
                <v-col>
                    <p class="text-h6 font-weight-regular">{{ getCategoryByParam ? getCategoryByParam.name : "All" }}</p>
                </v-col>
            </v-row>
            <v-divider class="mt-3"></v-divider>
            <v-row>
                <v-col md="4">
                    <v-list
                        variant="flat"
                        color="deep-orange"
                        nav
                        class="border-e-sm pt-3 pe-3"
                        @update:selected="setCategoryParam"
                    >
                        <v-list-item
                            v-for="(category, index) in productCategory"
                            :key="index"
                            :value="category.id"
                            :active="(paramCategoryId || 'All') === category.id"
                            variant="elevated"
                            class="mb-2 elevation-4"
                        >
                            <v-list-item-title>{{ category.name }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col md="8" class="ps-0 pt-6">
                    <v-row dense>
                        <v-col
                            v-for="(series, index) in getProductSeries"
                            :key="index"
                            md="3"
                        >
                            <a
                                v-if="!series.no_pdf"
                                :href="`${rawStorage.seriesPdf({
                                    manufactureId: manufactureType.id,
                                    vendorId: vendor.id,
                                    categoryId: series.mt_product_category_id,
                                    seriesId: series.id,
                                })}.pdf`"
                                target="_blank"
                            >
                                <v-card
                                    class="
                                        justify-center
                                        text-center
                                        align-center
                                        items-center
                                        card-product
                                    "
                                    elevation="4"
                                >
                                    <v-img
                                        height="130"
                                        cover
                                        :src="`${rawStorage.seriesImg({
                                            manufactureId: manufactureType.id,
                                            vendorId: vendor.id,
                                            categoryId: series.mt_product_category_id,
                                            seriesId: series.id,
                                        })}.jpg`"
                                    >
                                        <template #placeholder>
                                            <div
                                                class="d-flex justify-center align-center"
                                                style="height: 130px"
                                            >
                                                <v-progress-circular
                                                    indeterminate
                                                    width="5"
                                                    size="50"
                                                    color="deep-orange"
                                                />
                                            </div>
                                        </template>
                                        <template #error>
                                            <div
                                                class="d-flex justify-center align-center"
                                                style="height: 130px"
                                            >
                                                <v-icon
                                                    size="100"
                                                >mdi-image-off-outline</v-icon>
                                            </div>
                                        </template>
                                    </v-img>
                                    <v-divider class="mt-0 mb-3"></v-divider>
                                    <p class="px-3 text-left card-product-name">{{ series ? series.name : "" }}</p>
                                </v-card>
                            </a>
                            <v-card
                                v-else
                                class="
                                    justify-center
                                    text-center
                                    align-center
                                    items-center
                                    card-product
                                    position-relative
                                "
                                elevation="4"
                            >
                                <v-img
                                    height="130"
                                    cover
                                    :src="`${rawStorage.seriesImg({
                                        manufactureId: manufactureType.id,
                                        vendorId: vendor.id,
                                        categoryId: series.mt_product_category_id,
                                        seriesId: series.id,
                                    })}.jpg`"
                                >
                                    <template #placeholder>
                                        <div
                                            class="d-flex justify-center align-center"
                                            style="height: 130px"
                                        >
                                            <v-progress-circular
                                                indeterminate
                                                width="5"
                                                size="50"
                                                color="deep-orange"
                                            />
                                        </div>
                                    </template>
                                    <template #error>
                                        <div
                                            class="d-flex justify-center align-center"
                                            style="height: 130px"
                                        >
                                            <v-icon
                                                size="100"
                                            >mdi-image-off-outline</v-icon>
                                        </div>
                                    </template>
                                </v-img>
                                <v-divider class="mt-0 mb-3"></v-divider>
                                <p class="px-3 text-left card-product-name">{{ series ? series.name : "" }}</p>
                                <v-card class="position-absolute px-1 no-pdf-tag" color="red">
                                    PDF Not Available
                                </v-card>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </landing-page-layout>
</template>


<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { computed, onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import { Request } from "../../../utils/request";
import { rawStorage } from "../../../utils/storage";
import { useHead } from "@unhead/vue";


const router = useRouter();
const paramType = ref(null);
const paramVendorId = ref(null);
const vendor = ref(null);
const manufactureType = ref({ name: 'Manufacture' });
const productCategory = ref([]);
const selectedCategoryId = ref('All');
const categoryAll = { name: 'All', id: 'All' };
const selectVendor = ref(null);

useHead({
    title: 'Catalog'
});

const paramCategoryId = computed(() => {
    const category = router.currentRoute.value.query.category;
    return category
        ? (!isNaN(parseInt(category)) ? parseInt(category) : null)
        : null;
});
const getProductSeries = computed(() => {
    let tempCategory = [...productCategory.value];
    let tempSeries = [];

    if (paramCategoryId.value) {
        tempCategory = tempCategory.filter(cat => cat.id === paramCategoryId.value)
    }

    tempCategory = tempCategory.map(cat => {
        return (cat.mt_product_series || [])
            .map(item => tempSeries.push({
                ...item
            }));
    });

    return tempSeries;
});
const getCategoryByParam = computed(() => {
    const tempCategory = [...productCategory.value].filter(item => item.id === paramCategoryId.value);
    return tempCategory[0] || null;
});


onMounted(async () => {
    await onMountedAction();
});

const onMountedAction = async () => {
    paramType.value = router.currentRoute.value.params.type || null;
    paramVendorId.value = router.currentRoute.value.params.vendor_id || null;

    if (paramType.value && paramVendorId.value) {
        await fetchVendor();
        selectVendor.value = vendor.value.name;
        useHead({
            title: `${vendor.value.name} Catalog`
        })
    } else {
        router.back();
    }

    if (!router.currentRoute.value.query.category) {
        setCategoryParam([categoryAll.id]);
    }
}


const setCategoryParam = (categoryId) => {
    selectedCategoryId.value = categoryId[0];
    router.push(`/product/catalog/${manufactureType.value.name}/${paramVendorId.value}?category=${categoryId[0]}`)
}

const changeVendor = async (_vendor) => {
    await router.push(`/product/catalog/${paramType.value}/${_vendor.id}?category=All`);
    await onMountedAction();
}

const fetchVendor = async () => {
    await Request.get({
        url: `/api/vendor/detail/${paramVendorId.value}`,
        useLoading: true,
    })
        .then(({ data }) => {
            vendor.value = data.data;
            manufactureType.value = data.data.mt_manufacture_type;
            productCategory.value = [
                categoryAll,
                ...data.data.mt_product_category
            ];
        })
        .catch((err) => {});
}


watch(
    () => router.currentRoute.value.query,
    (newQuery) => {
        if (newQuery.category === undefined) {
            return router.back()
        }

        if (newQuery.category === 'undefined') {
            return router.push(`/product/catalog/${paramType.value}/${paramVendorId.value}?category=All`)
        }
    },
    { immediate: true }
);
</script>
