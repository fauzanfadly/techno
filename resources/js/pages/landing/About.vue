<template>
    <landing-page-layout id="pages-landing-engineering-services">
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
                                Abous Us
                            </p>
                            <p class="text-white text-subtitle-1">
                                We are a team of experienced professionals who are dedicated to providing the best possible service to our clients.
                            </p>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-container>
        
            <v-container class="py-10 pb-15">
                <v-row>
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

                <v-divider class="my-10"></v-divider>

                <v-row>
                    <v-col cols="12">
                        <p class="text-h5 mb-4">History</p>
                        <v-list lines="two">
                            <v-list-item
                                v-for="(history, index) in histories"
                                :key="index"
                                class="portfolio-item py-0"
                                slim
                            >
                                <template #prepend>
                                    <v-icon color="deep-orange">mdi-star</v-icon>
                                </template>
                                <v-list-item-title class="font-weight-bold">{{ history.date }}</v-list-item-title>
                                {{ history.project }}
                            </v-list-item>
                        </v-list>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </landing-page-layout>
</template>


<script setup>
import { ref } from "vue";
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { useHead } from "@unhead/vue";

useHead({
    title: 'About Us',
});

const histories = ref([
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

<style scoped>
.background-image {
    background-image: url('/images/engineering-services.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
}

.text-white-container {
    position: relative;
    z-index: 1;
}

.portfolio-item {
    position: relative;
    padding-left: 30px;
}

.portfolio-item::before {
    content: "";
    position: absolute;
    left: 40px;
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

.portfolio-item .v-list-item__prepend,
.portfolio-item .v-list-item__content {
    align-self: flex-start;
}

.bg-deep-orange {
    background-color: #FF5722;
    color: white;
}
</style> 