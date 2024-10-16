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
                        <p style="font-size: 2.5em" class="text-white text-h3 mb-3">
                            Engineering & Services
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
                    <p class="text-h5">Company Profile</p>
                    <!-- <p class="text-grey">
                        Click the one below that you want to see the vendor's products
                    </p> -->
                </v-col>
            </v-row>
            <v-row>
                <v-col sm="12" md="6">
                    <v-card
                        variant="tonal"
                        class="rounded-shaped mb-5"
                        elevation="4"
                    >
                        <v-container>
                            <v-row class="align-center">
                                <v-col sm="auto" md="auto">
                                    <div class="bg-deep-orange rounded-circle pa-3">
                                        <v-icon size="30">mdi-phone</v-icon>
                                    </div>
                                </v-col>
                                <v-col>
                                    <p class="text-subtitle-1">Call Us</p>
                                    <p class="text-h6">+62 (021) 8887 6969</p>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                    <v-card
                        variant="tonal"
                        class="rounded-shaped mb-5"
                        elevation="4"
                    >
                        <v-container>
                            <v-row class="align-center">
                                <v-col sm="auto" md="auto">
                                    <div class="bg-deep-orange rounded-circle pa-3">
                                        <v-icon size="30">mdi-email</v-icon>
                                    </div>
                                </v-col>
                                <v-col>
                                    <p class="text-subtitle-1">Send Us an E-Mail</p>
                                    <p class="text-h6">+62 (021) 8887 6969</p>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                    <v-card
                        variant="tonal"
                        class="rounded-shaped"
                        elevation="4"
                    >
                        <v-container>
                            <v-row class="align-center">
                                <v-col sm="auto" md="auto" align-self="start">
                                    <div class="bg-deep-orange rounded-circle pa-3 mt-3">
                                        <v-icon size="30">mdi-map-marker</v-icon>
                                    </div>
                                </v-col>
                                <v-col>
                                    <p class="text-subtitle-1">Visit Us</p>
                                    <p class="text-h6">PT. Techno</p>
                                    <p class="text-subtitle-2">Jl. Boulevard Barat L10, Perumahan Duta Harapan No.Kelurahan, RT.001/RW.013, Harapan Baru, Kec. Bekasi Utara, Kota Bks, Jawa Barat 17123</p>
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.89698286800188!2d107.02060543965501!3d-6.217262397036346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698f230ad97ca1%3A0xbb2561281cd38b31!2sTekuno%20Coffee%20%26%20Roastery!5e0!3m2!1sid!2sid!4v1728120726455!5m2!1sid!2sid"
                                        width="100%"
                                        height="200"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                    ></iframe>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
                <v-col sm="12" md="6">
                    <v-card
                        variant="tonal"
                        class="rounded-shaped"
                        elevation="4"
                    >
                        <v-container>
                            <v-row class="align-center">
                                <v-col sm="auto" md="auto">
                                    <p class="text-h5">Portfolio</p>
                                    <v-list class="portfolio-list" lines="two">
                                        <v-list-item
                                            v-for="(pfl, index) in portfolios"
                                            :key="index"
                                            class="portfolio-item py-0"
                                        >
                                            <template #prepend>
                                                <v-icon color="deep-orange">mdi-star</v-icon>
                                            </template>
                                            <v-list-item-title class="font-weight-bold text-grey-darken-2">{{ pfl.date }}</v-list-item-title>
                                            {{ pfl.project }}
                                        </v-list-item>
                                    </v-list>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </landing-page-layout>
</template>


<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { ref } from "vue";
import { useDynamicTitle } from "@/plugins/head";

useDynamicTitle("Engineering & Services");

const portfolios = ref([
    {
        date: '1969',
        project: 'OHMI SEIKI SHOKAI was founded at Tokyo.'
    },
    {
        date: '1971',
        project: 'OHMI SEIKI CO.,LTD. was established with a capital of half a million yen.'
    },
    {
        date: '1972',
        project: 'Increased of capital to 2 million yen.'
    },
    {
        date: '1975',
        project: 'Relocated factory to Kokubunji-shi Tokyo.'
    },
    {
        date: '1977',
        project: 'Relocated HQ to Kokubunji-shi Tokyo.'
    },
    {
        date: '1982',
        project: 'Increased of capital to 5 million yen.'
    },
    {
        date: '1996',
        project: 'Extended factory.'
    },
    {
        date: '1996',
        project: 'Increased of capital to 40 million yen.'
    },
    {
        date: '2004',
        project: 'Received ISO9001:2000 certificate.'
    },
    {
        date: '2009',
        project: 'Received ISO9001:2008 certificate.'
    },
    {
        date: '2012',
        project: 'Kenji Fujiki assumed the presidency.'
    },
    {
        date: '2016',
        project: 'Received ISO9001:2015 certificate'
    },
])
</script>

<style scoped>
.background-image {
    position: relative;
    background-image: url("https://www.thestreet.com/.image/ar_16:9%2Cc_fill%2Ccs_srgb%2Cg_faces:center%2Cq_auto:good%2Cw_768/MTY3NTM5MzU5MDg3MjczODcw/business-structure-which-type-is-best-for-your-business.png");
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

.portfolio-list {
    display: flex;
    flex-direction: column;
    position: relative;
}

.portfolio-item {
    position: relative;
    padding-left: 30px;
}

.portfolio-item::before {
    content: "";
    position: absolute;
    left: 26px;
    top: 27px;
    bottom: 0;
    width: 2px;
    border-radius: 10px;
    background-color: rgb(128, 128, 128);
    margin-bottom: 3px;
}

.portfolio-item:last-child::before {
    display: none;
}
</style>


<style>
.portfolio-item .v-list-item__prepend,
.portfolio-item .v-list-item__content {
    align-self: flex-start;
}
</style>
