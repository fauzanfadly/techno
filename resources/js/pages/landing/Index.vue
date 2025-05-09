<template>
    <landing-page-layout id="pages-landing-index">
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
import { onMounted, ref, watch } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";
import { useRoute, useRouter } from "vue-router";
import { useHead } from "@unhead/vue";

const router = useRouter();
const homeSection = ref(null);
const productsSection = ref(null);
const aboutSection = ref(null);
const contactSection = ref(null);
const pageTitle = ref('Home');

useHead({
    title: pageTitle.value,
});

onMounted(() => {
    AOS.init({
        duration: 800,
        once: true,
    });
    scrollToSection(router.currentRoute.value.name);
});

const scrollToSection = (sectionName) => {
    setTimeout(() => {
        if (sectionName === "landing-page") {
            homeSection.value.$el.scrollIntoView({ behavior: "smooth" });
            pageTitle.value = "Home";
        } else if (sectionName === "landing-page-products") {
            productsSection.value.$el.scrollIntoView({
                behavior: "smooth",
            });
            pageTitle.value = "Products";
        } else if (sectionName === "landing-page-about") {
            aboutSection.value.$el.scrollIntoView({ behavior: "smooth" });
            pageTitle.value = "About Us";
        } else if (sectionName === "landing-page-contact") {
            pageTitle.value = "Contact";
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: "smooth",
            });
        }

        useHead({
            title: pageTitle.value,
        })
    }, 100);
}

watch(
    () => router.currentRoute.value.name,
    (to, from) => {
        scrollToSection(to);
    },
    { immediate: true }
);
</script>
