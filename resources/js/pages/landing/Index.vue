<template>
    <landing-page-layout>
        <v-container fluid class="pa-0">
            <v-sheet height="100vh" class="background-image">
                <div class="overlay"></div>
                <v-row class="fill-height" align="center" justify="center">
                    <v-col cols="12" md="8" class="text-center text-white-container">
                        <h2 class="font-weight-medium text-white mb-2">Coming Soon</h2>
                        <h1 style="font-size: 2.5em;" class="font-weight-regular text-white">UNDER CONSTRUCTION</h1>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>
        <v-container fluid class="pa-0">
            <v-sheet height="100vh" class="background-image-2">
                <div class="overlay"></div>
                <v-row class="fill-height" align="center" justify="center">
                    <v-col cols="12" md="8" class="text-center text-white-container">
                        <h1 class="display-1 text-white">Welcome to Our Landing Page</h1>
                        <p class="text-white">Your tagline or subtitle goes here</p>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>
    </landing-page-layout>
</template>

<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { defineComponent } from "vue";

defineComponent([
    LandingPageLayout
])
</script>


<style scoped>
.background-image {
    position: relative;
    background-image: url('https://techno-triireka.co.id/images/slider_1_1920_1200.jpg');
    background-size: cover;
    background-position: center;
}

.background-image-2 {
    position: relative;
    background-image: url('https://techno-triireka.co.id/images/footer_1600x800.jpg');
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