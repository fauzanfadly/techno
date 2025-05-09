<template>
    <div id="components-landingpage-engineeringservices">
        <v-container fluid class="pa-0">
            <v-sheet height="50vh" class="background-image">
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
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>
    
        <!-- <v-parallax
            src="https://www.thestreet.com/.image/ar_16:9%2Cc_fill%2Ccs_srgb%2Cg_faces:center%2Cq_auto:good%2Cw_768/MTY3NTM5MzU5MDg3MjczODcw/business-structure-which-type-is-best-for-your-business.png"
            style="margin-top: -15px"
        > -->
            <v-container class="py-10 pb-15">
                <v-row>
                    <v-col cols="12">
                        <p class="text-h5">
                            Company Profile
                        </p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col sm="12" md="6">
                        <v-card
                            class="rounded-shaped mb-5"
                            elevation="6"
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
                            class="rounded-shaped mb-5"
                            elevation="6"
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
                            class="rounded-shaped"
                            elevation="6"
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
                            class="rounded-shaped portfolio-card"
                            elevation="6"
                        >
                            <v-container class="pa-0">
                                <v-row class="align-center">
                                    <v-col sm="auto" md="auto">
                                        <p class="text-h5 px-4 py-3">History</p>
                                        <v-divider></v-divider>
                                        <v-list class="portfolio-list bg-transparent overflow-y-scroll" lines="two">
                                            <v-list-item
                                                v-for="(pfl, index) in portfolios"
                                                :key="index"
                                                class="portfolio-item py-0"
                                                slim
                                            >
                                                <template #prepend>
                                                    <v-icon color="deep-orange">mdi-star</v-icon>
                                                </template>
                                                <v-list-item-title class="font-weight-bold">{{ pfl.date }}</v-list-item-title>
                                                {{ pfl.project }}
                                            </v-list-item>
                                        </v-list>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                    </v-col>
                </v-row>
    
                <v-row class="mt-10">
                    <v-col cols="12">
                        <div class="text-black text-body-1">
                            <p class="text-h5 d-flex align-center mb-3">
                                <v-icon
                                    size="60"
                                    color="deep-orange"
                                    class="me-5"
                                >mdi-account-group</v-icon>
                                Our Services
                            </p>
    
                            <p class="text-h6">Background</p>
                            <p>PT Techno Triireka was originally established as CV Mitra Techno in 2003, focusing on engineering as its principal business activity. In February 2008, the company transformed into PT Techno Triireka, expanding its business scope to include trading (Sales Division) and engineering (Engineering Division).</p>
                            <br>
    
                            <p class="text-h6">Sales Division</p>
                            <p>The Sales Division specializes in providing industrial machines and tools for use in factory sites, particularly in the automotive industry.</p>
                            <br>
    
                            <p class="text-h6">Engineering Division</p>
                            <p>The Engineering Division focuses on machining, fabrication, and designing specialized machinery for automotive companies.</p>
                            <br>
    
                            <p class="text-h6">Corporate Philosophy</p>
                            <p>In every business endeavor, we thoroughly assess customer requests and respond promptly to uphold our Corporate Philosophy triad:</p>
                            <br>
    
                            <p class="text-h6">Customer Satisfaction</p>
                            <v-list density="compact">
                                <v-list-item slim><template #prepend><v-icon color="deep-orange">mdi-star-circle</v-icon></template> Quality Improvement</v-list-item>
                                <v-list-item slim><template #prepend><v-icon color="deep-orange">mdi-star-circle</v-icon></template> Originality and Ingenuity</v-list-item>
                                <v-list-item slim><template #prepend><v-icon color="deep-orange">mdi-star-circle</v-icon></template> Commitment to Sustainability</v-list-item>
                                <v-list-item slim><template #prepend><v-icon color="deep-orange">mdi-star-circle</v-icon></template> We place great importance on offering eco-friendly products, always striving to propose innovative solutions that exceed customer expectations.</v-list-item>
                            </v-list>
                            <br>
    
                            <p class="text-h6">Our Mission</p>
                            <p>We are committed to becoming "Your Truly Global Partner" by delivering reliability, satisfaction, and tailored solutions to meet the diverse needs of our customers.</p>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        <!-- </v-parallax> -->
    </div>
</template>


<script setup>
import { ref } from "vue";
import EngineeringServices from '@/components/LandingPage/EngineeringServices.vue';

const portfolios = ref([
    {
        date: '2003',
        project: 'CV Mitra Techno has established'
    },
    {
        date: '2008',
        project: 'CV Mitra Techno was change become PT Techno Triireka'
    },
    {
        date: '2015 - May',
        project: 'Authorized Partner BIBIELLE'
    },
    {
        date: '2015 - June',
        project: 'Appointment Of Authorized Distributor SANKYO RIKAGAKU'
    },
    {
        date: '2015 - July',
        project: 'Authorized Distributor POSILIFT'
    },
    {
        date: '2015 - October',
        project: 'Appointment Of Authorized Distributor OHMI SEIKI'
    },
    {
        date: '2017 - October',
        project: 'Appointment Of Authorized Distributor OHMI SEIKI'
    },
    {
        date: '2017 - August',
        project: 'Authorized Distributor HANGCHA & NOBILIFT'
    },
    {
        date: '2022 - November',
        project: 'Authorized Distributor WETZEL, LUVATA, MEECH, SEM INDUSTRY TECHNOLOGY, and MODULAR'
    },
    {
        date: '2024 - May',
        project: 'Distributor Certification MYTORQ'
    },
])
</script>
