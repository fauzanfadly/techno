<template>
    <landing-page-layout>
        <v-container ref="homeSection" fluid class="pa-0">
            <v-sheet height="100vh" class="background-image">
                <div class="overlay"></div>
                <v-row class="fill-height" align="center" justify="center">
                    <v-col
                        cols="12"
                        md="8"
                        class="text-center text-white-container"
                        data-aos="fade-up"
                    >
                        <!-- <p class="text-white mb-2 text-h5">Coming Soon</p> -->
                        <p
                            style="letter-spacing: 10px !important"
                            class="text-white text-h3 mb-3"
                        >
                            TECHNO
                        </p>
                        <p class="text-white text-subtitle-1">
                            Your Trusted Global Partner in Engineering &
                            Industrial Solutions since 2003. We specialize in
                            delivering top-quality machinery, tools, and custom
                            engineering services with a commitment to Customer
                            Satisfaction, Quality Improvement, and Innovation.
                            Eco-friendly and tailored solutions for the
                            automotive industry, designed to exceed
                            expectations.
                        </p>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>

        <products ref="productsSection" data-aos="fade-up"></products>

        <v-container ref="aboutSection" fluid class="pa-0">
            <v-sheet height="100vh" class="background-image-about">
                <div class="overlay"></div>
                <v-row class="fill-height" align="center" justify="center">
                    <v-col
                        cols="12"
                        md="8"
                        class="text-center text-white-container"
                        data-aos="fade-up"
                    >
                        <!-- <p class="text-white mb-2 text-h5">Coming Soon</p> -->
                        <p class="text-white text-h4 mb-10">ABOUT US</p>
                        <p class="text-white text-subtitle-1">
                            PT.MITRA TECHNO has established in 2003, we have
                            developed an engineering business as our principal
                            business activities of the company. At February 2008
                            CV Mitra Techno was change become PT Techno
                            Triireka. PT Techno Triireka has developed trading
                            business (Sales Division) and engineering business
                            (Engineering Division) as our principal business
                            activities of the company. The sales division is
                            focusing on providing the industrial machines and
                            the tools used at the factory site of the automotive
                            industry. The engineering division is focusing on
                            machining, fabrication, design for a special
                            machineries on automotive company.
                        </p>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>
    </landing-page-layout>
</template>

<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import Products from "@/components/LandingPage/Products.vue";
import { nextTick, onMounted, ref, watch } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";
import { useRoute } from "vue-router";
import { useDynamicTitle } from "@/plugins/head";

const route = useRoute();
const homeSection = ref(null);
const productsSection = ref(null);
const aboutSection = ref(null);
const contactSection = ref(null);

onMounted(() => {
    AOS.init({
        duration: 800,
        once: true,
    });
    scrollToSection(route.name);
});

function scrollToSection(sectionName) {
    setTimeout(() => {
        if (sectionName === "landing-page") {
            homeSection.value.$el.scrollIntoView({ behavior: "smooth" });
            useDynamicTitle("Home");
        } else if (sectionName === "landing-page-products") {
            productsSection.value.$el.scrollIntoView({
                behavior: "smooth",
            });
            useDynamicTitle("Products");
        } else if (sectionName === "landing-page-about") {
            aboutSection.value.$el.scrollIntoView({ behavior: "smooth" });
            useDynamicTitle("About Us");
        } else if (sectionName === "landing-page-contact") {
            useDynamicTitle("Contact");
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: "smooth",
            });
        }
    }, 100);
}

watch(
    () => route.name,
    (newV, oldV) => {
        scrollToSection(newV);
    }
);
</script>

<style scoped>
.background-image {
    position: relative;
    background-image: url("https://techno-triireka.co.id/images/slider_1_1920_1200.jpg");
    background-size: cover;
    background-position: center;
}

.background-image-about {
    position: relative;
    background-image: url("https://techno-triireka.co.id/images/footer_1600x800.jpg");
    background-size: cover;
    background-position: center;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    /* Dark overlay with 50% opacity */
    z-index: 1;
}

.text-white-container {
    position: relative;
    z-index: 2;
}
</style>
