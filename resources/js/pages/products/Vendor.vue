<template>
    <landing-page-layout id="pages-products-vendor">
        <EngineeringServices v-if="paramType === 'Engineering & Services'" />
        <div v-else>
            <v-container fluid class="pa-0">
                <v-sheet height="45vh" class="background-image">
                    <div class="overlay"></div>
                    <v-row
                        class="fill-height pt-15"
                        align="center"
                        justify="center"
                    >
                        <v-col cols="12" md="8" class="text-white-container">
                            <p class="text-white mb-2 text-h5">Product</p>
                            <p style="font-size: 2.5em" class="text-white text-h3 mb-3">
                                {{ manufactureType.name || 'Manufacture' }}
                            </p>
                            <p class="text-white">
                                {{ manufactureType.description || "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." }}
                            </p>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-container>
    
            <v-container class="py-10 pb-15">
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
                                    @click="$router.push(`/product/catalog/${manufactureType.name}/${vendor.id}`)"
                                >
                                    <v-row dense>
                                        <v-col cols="auto">
                                            <v-img
                                                :src="`${rawStorage.vendorImg({
                                                    manufactureId: vendor.mt_manufacture_type_id,
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
                                        v-if="vendor.mt_product_category.length > 0"
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
                                            @click="$router.push(`/product/catalog/${manufactureType.name}/${vendor.id}`)"
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
                                            @click="$router.push(`/product/catalog/${manufactureType.name}/${vendor.id}?category=${category.id}`)"
                                        >
                                            <v-img
                                                height="130"
                                                cover
                                                :src="`${rawStorage.seriesImg({
                                                    manufactureId: manufactureType.id,
                                                    vendorId: category.mt_vendor_id,
                                                    categoryId: category.id,
                                                    seriesId: category.mt_product_series.length > 0 ? category.mt_product_series[0].id : null,
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
import EngineeringServices from '@/components/LandingPage/EngineeringServices.vue';
import { onMounted, ref, watch } from "vue";
import { Request } from "../../utils/request";
import { useRouter } from "vue-router";
import { getStorageFile, rawStorage } from "../../utils/storage";
import { useHead } from "@unhead/vue";

const router = useRouter();
const paramType = ref(null);
const panels = ref([0]);
const manufactureType = ref({});
const vendors = ref([]);

useHead({
    title: router.currentRoute.value.params.type
});

onMounted(async () => {
    paramType.value = router.currentRoute.value.params.type || null;

    if (paramType.value) {
        await fetchManufactureType();
    } else {
        router.back();
    }
});


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


watch(
    () => router.currentRoute.value.params,
    (newParams) => {
        paramType.value = newParams.type;
        if (paramType.value) {
            useHead({
                title: paramType.value
            });
            fetchManufactureType();
        } else {
            router.back();
        }
    },
    { immediate: true }
);
</script>
