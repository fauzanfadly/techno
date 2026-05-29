<template>
    <div class="bg-deep-orange-darken-2 w-full" id="main-footer">
        <v-container class="py-10">
            <v-row>
                <v-col xs="12" sm="12" md="3" class="text-white-container">
                    <p class="text-white text-h4 mb-0">PT. Techno</p>
                    <v-divider
                        class="border-white opacity-100 mb-5"
                    ></v-divider>
                    <div class="text-white text-subtitle-2">
                        <p class="mb-3">
                            <v-icon icon="mdi-phone"></v-icon>
                            +62 (021) 8887 6969
                        </p>
                        <p class="mb-3">
                            <v-icon icon="mdi-email-outline"></v-icon>
                            sales@techno-triireka.co.id
                        </p>
                        <p class="mb-3">
                            <v-icon icon="mdi-map-marker-outline"></v-icon>
                            Address : Jl. Duta Boulevard L10, Duta Harapan,
                            Harapan Baru, Bekasi Utara Kota Bekasi, Jawa Barat -
                            Indonesia 17123
                        </p>
                    </div>
                </v-col>
                <v-spacer></v-spacer>
                <v-col xs="12" sm="12" md="3" class="text-white-container">
                    <p class="text-white text-h5 mt-4 mb-5">Products</p>
                    <div class="text-subtitle-2">
                        <p
                            v-for="(type, index) in manufatureTypes"
                            :key="index"
                            class="mb-3"
                        >
                            <v-icon icon="mdi-menu-right"></v-icon>
                            <router-link
                                class="text-white"
                                :to="`/product/${type.name}`"
                            >
                                {{ type.name }}
                            </router-link>
                        </p>
                    </div>
                </v-col>
                <v-col xs="12" sm="12" md="2" class="text-white-container">
                    <p class="text-white text-h5 mt-4 mb-5">Navigate</p>
                    <div class="text-subtitle-2">
                        <p class="mb-3">
                            <v-icon icon="mdi-menu-right"></v-icon>
                            <router-link
                                class="text-white"
                                :to="{ name: 'landing-page' }"
                            >
                                Home
                            </router-link>
                        </p>
                        <p class="mb-3">
                            <v-icon icon="mdi-menu-right"></v-icon>
                            <router-link
                                class="text-white"
                                :to="{ name: 'product-list' }"
                            >
                                Products
                            </router-link>
                        </p>
                        <p class="mb-3">
                            <v-icon icon="mdi-menu-right"></v-icon>
                            <router-link
                                class="text-white"
                                :to="{ name: 'landing-page-engineering-services' }"
                            >
                                Engineering Services
                            </router-link>
                        </p>
                        <p class="mb-3">
                            <v-icon icon="mdi-menu-right"></v-icon>
                            <router-link
                                class="text-white"
                                :to="{ name: 'landing-page-about' }"
                            >
                                About Us
                            </router-link>
                        </p>
                        <p class="mb-3">
                            <v-icon icon="mdi-menu-right"></v-icon>
                            <router-link
                                class="text-white"
                                :to="{ name: 'landing-page-contact' }"
                            >
                                Contact
                            </router-link>
                        </p>
                    </div>
                </v-col>
            </v-row>
        </v-container>
        <v-container fluid class="bg-deep-orange-darken-4 text-caption py-0">
            <v-row>
                <v-col class="pa-0">
                    Copyright © 2024 All rights reserved by Techno
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>


<script setup>
import { onMounted, ref } from "vue";
import { RouterLink } from "vue-router";
import { Request } from "../utils/request";
import { getStorageFile } from "../utils/storage";


const manufatureTypes = ref([]);


onMounted(async () => {
    await fetchManufactureTypes();
})


const fetchManufactureTypes = async () => {
    await Request.get({
        url: "/api/manufacture-type",
        useLoading: true
    })
        .then(({ data }) => {
            manufatureTypes.value = data.data || [];
        });
}
</script>
