<template>
    <landing-page-layout>
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
                            Assemble
                        </p>
                        <p class="text-white">
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua.
                        </p>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>

        <v-container class="py-10 pb-15">
            <v-row>
                <v-col>
                    <p class="text-h5">Vendors</p>
                    <p class="text-grey">
                        Click the one below that you want to see the vendor's products
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
                    <v-expansion-panels variant="accordion">
                        <v-expansion-panel class="bg-grey-lighten-3">
                            <v-expansion-panel-title v-text="vendor.name" color="deep-orange-lighten-4" />
                            <v-expansion-panel-text>
                                <v-list lines="one" class="bg-transparent">
                                    <v-list-item
                                        v-for="(product, subIndex) in vendor.products"
                                        :key="subIndex"
                                    >
                                        <div class="d-flex align-center pb-3">
                                            <v-btn
                                                size="sm"
                                                color="deep-orange"
                                                class="px-3 py-1 text-subtitle-2 rounded-pill"
                                                :href="product.url"
                                                target="_blank"
                                            >
                                                <v-icon size="20" class="me-1">mdi-download</v-icon>
                                                PDF
                                            </v-btn>
                                            <v-list-item-title v-text="product.name" class="ps-4" />
                                        </div>
                                        <!-- <v-divider /> -->
                                    </v-list-item>
                                </v-list>
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
    </landing-page-layout>
</template>


<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { ref } from "vue";

const vendors = ref([
    {
        name: "OHMI",
        // description: "OHMI description",
        products: [
            {
                name: "Driver Bits",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/1-0.pdf",
            },
            {
                name: "Impact Sockets",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/2-0.pdf",
            },
            {
                name: "Accessories",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/3-0.pdf",
            },
            {
                name: "Point Size Selector",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/9-0.pdf",
            },
        ],
    },
    {
        name: "MYTORQ",
        // description: "MYTORQ description",
        products: [
            {
                name: "Driver Bits",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/1-0.pdf",
            },
            {
                name: "Impact Sockets",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/2-0.pdf",
            },
            {
                name: "Accessories",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/3-0.pdf",
            },
            {
                name: "Point Size Selector",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/9-0.pdf",
            },
        ],
    },
    {
        name: "Sanyo",
        // description: "Sanyo description",
        products: [
            {
                name: "Driver Bits",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/1-0.pdf",
            },
            {
                name: "Impact Sockets",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/2-0.pdf",
            },
            {
                name: "Accessories",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/3-0.pdf",
            },
            {
                name: "Point Size Selector",
                url: "http://www.ohmiseiki.co.jp/en/cms/upload/product_custommade_pdf/9-0.pdf",
            },
        ],
    },
]);
</script>

<style scoped>
.background-image {
    position: relative;
    background-image: url("https://www.mytorqtools.com/images/d1-img1.jpg");
    background-size: cover;
    background-position: center;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    /* Dark overlay with 50% opacity */
    z-index: 1;
}

.text-white-container {
    position: relative;
    z-index: 2;
}
</style>
