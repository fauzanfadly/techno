<template>
    <landing-page-layout id="pages-products-vendor">
        <div>
            <v-container fluid class="pa-0">
                <v-sheet
                    height="45vh"
                    class="background-image"
                    :style="{ backgroundImage: manufactureType.image ? `url(${getStorageFile(manufactureType.image.image_path)})` : 'none' }"
                >
                    <div class="overlay"></div>
                    <v-row
                        class="fill-height pt-15"
                        align="center"
                        justify="center"
                    >
                        <v-col cols="12" md="8" class="text-white-container">
                            <p class="text-white mb-2 text-h5">Product</p>
                            <p style="font-size: 2.5em" class="text-white text-h3 mb-3">
                                {{ paramType === 'all' ? 'Our Products' : manufactureType.name }}
                            </p>
                            <p class="text-white">
                                {{ manufactureType.description || "Discover our wide range of high-quality products from trusted manufacturers. Browse through various categories and find the perfect solution for your needs." }}
                            </p>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-container>

            <!-- Toggle Manufacture Types (selalu tampil) -->
            <v-container class="py-5">
                <v-row>
                    <v-col>
                        <p class="text-h5">Product Categories</p>
                        <p class="text-grey">
                            Select a product category to explore
                        </p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-chip-group
                            mandatory
                            selected-class="deep-orange white--text"
                            v-model="paramType"
                        >
                            <v-chip
                                value="all"
                                :active="paramType === 'all'"
                                @click="$router.push('/product')"
                                class="ma-1"
                                filter
                                variant="elevated"
                                :color="paramType === 'all' ? 'deep-orange' : ''"
                                :class="paramType === 'all' ? 'white--text' : ''"
                            >
                                All Products
                            </v-chip>
                            <v-chip
                                v-for="(type, index) in manufactureTypes"
                                :key="index"
                                :value="type.name"
                                :active="paramType === type.name"
                                @click="$router.push(`/product/${type.name}`)"
                                class="ma-1"
                                filter
                                variant="elevated"
                                :color="paramType === type.name ? 'deep-orange' : undefined"
                                :class="paramType === type.name ? 'white--text' : ''"
                            >
                                {{ type.name }}
                            </v-chip>
                        </v-chip-group>
                    </v-col>
                </v-row>
            </v-container>

            <v-divider></v-divider>

            <!-- Vendor list (tampil jika ada paramType atau all products) -->
            <v-container class="py-5 mb-15">
                <v-row>
                    <v-col>
                        <p class="text-h5">Distributors</p>
                        <p class="text-grey">
                            Click the one below that you want to see the distributor's products
                        </p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                        v-for="(vendor, index) in vendors"
                        :key="index"
                        sm="12"
                        md="12"
                        class="pb-0"
                    >
                        <v-expansion-panels
                            variant="accordion"
                            v-model="panels"
                            class="border rounded-lg overflow-hidden"
                            elevation="0"
                            readonly
                        >
                            <v-expansion-panel class="bg-grey-lighten-3" hide-actions="">
                                <v-expansion-panel-title
                                    color="white"
                                    class="text-h6"
                                    @click="$router.push(`/product/catalog/${vendor.mt_manufacture_type ? vendor.mt_manufacture_type.name : 'all'}/${vendor.id}`)"
                                >
                                    <v-row dense>
                                        <v-col cols="auto">
                                            <v-img
                                                :src="`${rawStorage.vendorImg({
                                                    manufactureId: vendor.mt_manufacture_type_id || 0,
                                                    vendorId: vendor.id,
                                                })}.png`"
                                                width="100"
                                                height="40"
                                            >
                                            </v-img>
                                        </v-col>
                                        <v-col cols="auto" align-self="center">
                                            {{ vendor.name }}
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-spacer></v-spacer>
                                        <v-spacer></v-spacer>
                                    </v-row>
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <div
                                        v-if="vendor.mt_product_category && vendor.mt_product_category.length > 0"
                                        class="d-flex
                                            flex-row
                                            py-3
                                            overflow-x-hidden
                                            position-relative
                                        "
                                    >
                                        <v-card
                                            color="deep-orange"
                                            style="z-index: 999;"
                                            class="
                                                position-absolute
                                                right-0
                                                justify-center
                                                text-center
                                                align-center
                                                items-center
                                                card-category-see-more
                                                elevation-5
                                            "
                                            @click="$router.push(`/product/catalog/${vendor.mt_manufacture_type ? vendor.mt_manufacture_type.name : 'all'}/${vendor.id}`)"
                                        >
                                            <v-icon
                                                size="100"
                                            >mdi-dots-horizontal</v-icon>
                                            <div class="py-3">See more...</div>
                                        </v-card>
                                        <v-card
                                            v-for="(category, subIndex) in vendor.mt_product_category"
                                            :key="subIndex"
                                            class="
                                                justify-center
                                                text-center
                                                align-center
                                                items-center
                                                me-5
                                                card-category
                                            "
                                            @click="$router.push(`/product/catalog/${vendor.mt_manufacture_type ? vendor.mt_manufacture_type.name : 'all'}/${vendor.id}?category=${category.id}`)"
                                        >
                                            <v-img
                                                height="130"
                                                cover
                                                :src="`${rawStorage.seriesImg({
                                                    manufactureId: vendor.mt_manufacture_type_id || 0,
                                                    vendorId: category.mt_vendor_id,
                                                    categoryId: category.id,
                                                    seriesId: category.mt_product_series && category.mt_product_series.length > 0 ? category.mt_product_series[0].id : null,
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
                                            <v-divider></v-divider>
                                            <div class="py-2 px-3 text-truncate text-subtitle-2">{{ category.name }}</div>
                                        </v-card>
                                    </div>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                        </v-expansion-panels>
                        <v-divider
                            v-if="index !== vendors.length - 1"
                            class="mt-3"
                        />
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </landing-page-layout>
</template>


<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { onMounted, ref, watch } from "vue";
import { Request } from "../../utils/request";
import { useRouter } from "vue-router";
import { getStorageFile, rawStorage } from "../../utils/storage";
import { useHead } from "@unhead/vue";

const router = useRouter();
const paramType = ref('all');
const panels = ref([0]);
const manufactureType = ref({});
const vendors = ref([]);
const manufactureTypes = ref([]);

// Pindahkan useHead ke dalam setup dan gunakan computed untuk nilai dinamis
const title = ref(router.currentRoute.value.params.type || 'Our Products');
useHead({
    title
});

onMounted(async () => {
    paramType.value = router.currentRoute.value.params.type || 'all';
    await fetchAllManufactureTypes();

    if (paramType.value) {
        await fetchManufactureType();
    } else {
        await fetchAllVendors();
    }    
});

const fetchAllManufactureTypes = async () => {
    await Request.get({
        url: "/api/manufacture-type",
        useLoading: true
    })
        .then(({ data }) => {
            manufactureTypes.value = data.data || [];
        })
        .catch((err) => {});
}

const fetchManufactureType = async () => {
    await Request.get({
        url: `/api/manufacture-type/detail/name/${paramType.value}`,
        useLoading: true,
    })
        .then(({ data }) => {
            vendors.value = data.data.mt_vendor;
            manufactureType.value = data.data;
        })
        .catch((err) => {});
}

const fetchAllVendors = async () => {
    await Request.get({
        url: "/api/vendor",
        useLoading: true
    })
        .then(({ data }) => {
            vendors.value = data.data || [];
        })
        .catch((err) => {});
}

watch(
    () => router.currentRoute.value.params,
    (newParams) => {
        if (newParams.type) {
            title.value = paramType.value;
            fetchManufactureType();
        } else {
            title.value = 'Our Products';
            fetchAllVendors();
        }
    },
    { immediate: true }
);
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
.transition-swing {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
}
.transition-swing:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
}
.background-image {
    background-size: cover;
    background-position: center;
    position: relative;
}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
}
.text-white-container {
    position: relative;
    z-index: 2;
}
</style>
