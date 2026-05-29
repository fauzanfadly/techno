<template>
    <landing-page-layout id="pages-engineering-services">
        <v-container fluid class="pa-0">
            <v-sheet height="50vh" class="background-image-engineering">
                <div class="overlay"></div>
                <v-row class="fill-height" align="center" justify="center">
                    <v-col cols="12" md="8" class="text-white-container" data-aos="fade-up">
                        <p class="text-white text-h3 mb-3">Engineering & Services</p>
                        <p class="text-white text-subtitle-1">
                            High quality engineering solutions for automotive and manufacturing industries
                        </p>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>

        <v-container class="py-12">
            <v-row>
                <v-col cols="12" class="mb-8" data-aos="fade-up">
                    <h2 class="text-h4 text-center mb-8 font-weight-bold primary--text">Our Services</h2>
                    <p class="text-center text-body-1 mx-auto" style="max-width: 800px;">
                        We offer high quality engineering solutions for automotive and manufacturing industries. 
                        With extensive experience and expertise, we are ready to help you achieve optimal production goals.
                    </p>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="100">
                    <v-card elevation="3" class="service-card h-100">
                        <v-card-title class="text-h6 primary--text d-flex align-center">
                            <v-icon size="24" color="primary" class="mr-2">mdi-wrench</v-icon>
                            Jig / Fixtures
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div v-for="(item, i) in jigFixtures" :key="i" class="d-flex align-center mb-2">
                                <div class="circle-icon mr-3"></div>
                                <span>{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="200">
                    <v-card elevation="3" class="service-card h-100">
                        <v-card-title class="text-h6 primary--text d-flex align-center">
                            <v-icon size="24" color="primary" class="mr-2">mdi-cog-outline</v-icon>
                            Assembly S/A Machine
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div v-for="(item, i) in assemblyMachine" :key="i" class="d-flex align-center mb-2">
                                <div class="circle-icon mr-3"></div>
                                <span>{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="300">
                    <v-card elevation="3" class="service-card h-100">
                        <v-card-title class="text-h6 primary--text d-flex align-center">
                            <v-icon size="24" color="primary" class="mr-2">mdi-robot-industrial</v-icon>
                            Nut Runner Assembly Machine
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div v-for="(item, i) in nutRunnerAssembly" :key="i" class="d-flex align-center mb-2">
                                <div class="circle-icon mr-3"></div>
                                <span>{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="400">
                    <v-card elevation="3" class="service-card h-100">
                        <v-card-title class="text-h6 primary--text d-flex align-center">
                            <v-icon size="24" color="primary" class="mr-2">mdi-factory</v-icon>
                            Triming Assembly Line
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div v-for="(item, i) in trimingAssembly" :key="i" class="d-flex align-center mb-2">
                                <div class="circle-icon mr-3"></div>
                                <span>{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="500">
                    <v-card elevation="3" class="service-card h-100">
                        <v-card-title class="text-h6 primary--text d-flex align-center">
                            <v-icon size="24" color="primary" class="mr-2">mdi-tools</v-icon>
                            Preparation Line
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div v-for="(item, i) in preparationLine" :key="i" class="d-flex align-center mb-2">
                                <div class="circle-icon mr-3"></div>
                                <span>{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="600">
                    <v-card elevation="3" class="service-card h-100">
                        <v-card-title class="text-h6 primary--text d-flex align-center">
                            <v-icon size="24" color="primary" class="mr-2">mdi-shape-outline</v-icon>
                            Alumunium Profile
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <p class="text-body-1">High-quality aluminum profile solutions for various industrial needs.</p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-row class="mt-12">
                <v-col cols="12" class="text-center" data-aos="fade-up">
                    <v-btn color="primary" x-large rounded class="px-8 elevation-3">
                        <v-icon left class="mr-2">mdi-phone</v-icon>
                        Contact Us
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>

        <!-- <v-container class="grey lighten-4 py-12">
            <v-row>
                <v-col cols="12" class="text-center mb-8" data-aos="fade-up">
                    <h2 class="text-h4 font-weight-bold primary--text">Our Service Excellence</h2>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="12" md="4" data-aos="fade-up" data-aos-delay="100">
                    <v-card class="text-center pa-4 h-100 service-card" elevation="2">
                        <v-avatar size="80" color="primary" class="mb-4">
                            <v-icon size="40" color="white">mdi-certificate</v-icon>
                        </v-avatar>
                        <h3 class="text-h6 mb-3">Guaranteed Quality</h3>
                        <p>We use high-quality materials and the latest technology to ensure durable and reliable products.</p>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4" data-aos="fade-up" data-aos-delay="200">
                    <v-card class="text-center pa-4 h-100 service-card" elevation="2">
                        <v-avatar size="80" color="primary" class="mb-4">
                            <v-icon size="40" color="white">mdi-account-group</v-icon>
                        </v-avatar>
                        <h3 class="text-h6 mb-3">Expert Team</h3>
                        <p>Our team of technicians and engineers have extensive experience in the automotive and manufacturing industries.</p>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4" data-aos="fade-up" data-aos-delay="300">
                    <v-card class="text-center pa-4 h-100 service-card" elevation="2">
                        <v-avatar size="80" color="primary" class="mb-4">
                            <v-icon size="40" color="white">mdi-clock-check-outline</v-icon>
                        </v-avatar>
                        <h3 class="text-h6 mb-3">On-Time Delivery</h3>
                        <p>We are committed to completing projects on schedule without compromising quality.</p>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>

        <v-container class="py-16">
            <v-row>
                <v-col cols="12" class="text-center mb-10" data-aos="fade-up">
                    <h2 class="text-h4 font-weight-bold primary--text">Client Testimonials</h2>
                    <p class="text-subtitle-1 mt-3 mx-auto" style="max-width: 700px;">
                        See what our clients say about our engineering services
                    </p>
                </v-col>
            </v-row>

            <v-row justify="center">
                <v-col cols="12" md="10">
                    <v-carousel
                        hide-delimiters
                        height="auto"
                        :show-arrows="false"
                        cycle
                        interval="5000"
                    >
                        <v-carousel-item v-for="(testimonial, i) in testimonials" :key="i">
                            <v-card class="pa-8 text-center mx-auto" max-width="800" elevation="0">
                                <v-avatar size="100" class="mb-4">
                                    <v-img :src="testimonial.avatar" alt="Avatar"></v-img>
                                </v-avatar>
                                <div class="mb-6">
                                    <v-icon color="amber" v-for="n in 5" :key="n">mdi-star</v-icon>
                                </div>
                                <p class="text-h6 font-italic mb-6">
                                    "{{ testimonial.text }}"
                                </p>
                                <p class="text-subtitle-1 font-weight-bold mb-1">{{ testimonial.name }}</p>
                                <p class="text-subtitle-2 grey--text">{{ testimonial.position }}, {{ testimonial.company }}</p>
                            </v-card>
                        </v-carousel-item>
                    </v-carousel>
                </v-col>
            </v-row>
        </v-container>

        <v-container fluid class="cta-section py-16">
            <div class="overlay-dark"></div>
            <v-row class="fill-height" align="center" justify="center">
                <v-col cols="12" md="8" class="text-center position-relative" data-aos="fade-up">
                    <h2 class="text-h3 text-white mb-6">Need Engineering Solutions?</h2>
                    <p class="text-white text-subtitle-1 mb-8">
                        Consult your technical needs with our expert team and get the best solutions for your business.
                    </p>
                    <v-btn color="white" x-large dark rounded class="px-8 elevation-3 primary--text">
                        <v-icon left class="mr-2">mdi-email</v-icon>
                        Contact Us Now
                    </v-btn>
                </v-col>
            </v-row>
        </v-container> -->
    </landing-page-layout>
</template>

<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { onMounted, ref } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";
import { useHead } from "@unhead/vue";

useHead({
    title: 'Engineering Services',
});

const jigFixtures = ref([
    'OIL PANHOLE DIE CASTING',
    'RING PISTON INSERTER ASSY',
    'ENGINE & TRANSMISSION ASSY',
    'ENGINE NUMBERING',
    'CYLINDERHEAD COVER MACHINING',
    'ENGINE BELT TENSION',
    'STICK PKB TESTER',
    'JIG DOOR GLASS'
]);

const assemblyMachine = ref([
    'STEERING COLUMN S/A TABLE',
    'BRAKE TUBE S/A TABLE',
    'ACTUATOR S/A TABLE',
    'PEDAL S/A TABLE',
    'PBS LIFTER'
]);

const nutRunnerAssembly = ref([
    'TYRE WHEEL HUB',
    'FRONT SUSPENSION MEMBER',
    'REAR SUSPENSION',
    'DRIVE SHAFT',
    'DRIVE PLATE'
]);

const trimingAssembly = ref([
    'DOOR OFF',
    'DOOR ON',
    'COCKPIT',
    'SEAT',
    'FUEL TANK',
    'TYRE LOAD'
]);

const preparationLine = ref([
    'BEARING PRESS MACHINE',
    'HUB PRESS MACHINE',
    'FRONT VERTICAL ASSY',
    'FRONT HORIZONTAL',
    'SPRING COMPRESSION',
    'ROTOR FLATNESS CHECK',
    'SHIELD ASSEMBLY TABLE',
    'RUN OUT ASSY JIG'
]);

const testimonials = ref([
    {
        name: 'John Smith',
        position: 'Production Manager',
        company: 'PT Automotive Indonesia',
        text: 'The engineering services from the Techno team have greatly helped us improve production efficiency. The quality of their jigs and fixtures is very precise and durable.',
        avatar: '/images/slider_1_1920_1200.jpg'
    },
    {
        name: 'Emma Johnson',
        position: 'Operations Director',
        company: 'Astra Manufacturing',
        text: 'We have been working with Techno for more than 5 years and have always been satisfied with their work. Their team is very professional and responsive to our needs.',
        avatar: '/images/slider_1_1920_1200.jpg'
    },
    {
        name: 'Michael Chen',
        position: 'Head of Engineering Division',
        company: 'Toyota Indonesia',
        text: 'The assembly line solutions provided by Techno have helped us increase productivity by up to 30%. They understand the needs of the automotive industry very well.',
        avatar: '/images/slider_1_1920_1200.jpg'
    }
]);

onMounted(() => {
    AOS.init({
        duration: 800,
        once: true,
    });
});
</script>

<style scoped>
.background-image-engineering {
    background-image: url('/images/slider_1_1920_1200.jpg');
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
    background-color: rgba(0, 0, 0, 0.6);
}

.text-white-container {
    position: relative;
    z-index: 1;
}

.service-card {
    transition: all 0.3s ease;
    height: 100%;
    border-radius: 8px;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15) !important;
}

.h-100 {
    height: 100%;
}

.transparent {
    background-color: transparent !important;
}

.cta-section {
    background-image: url('/images/footer_1600x800.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    position: relative;
    min-height: 400px;
}

.overlay-dark {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.7);
}

.position-relative {
    position: relative;
    z-index: 2;
}

.v-list-item {
    min-height: 32px !important;
}

.v-list-item__icon {
    margin-top: 4px !important;
    margin-bottom: 4px !important;
}

.v-list-item__content {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
}

.circle-icon {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #1976D2; /* primary color */
    flex-shrink: 0;
    margin-top: 3px;
}

.d-flex.align-center.mb-2 {
    margin-bottom: 16px !important;
    align-items: flex-start !important;
}

.d-flex.align-center.mb-2 span {
    font-size: 15px;
    font-weight: 500;
    line-height: 1.2;
    color: rgba(0, 0, 0, 0.8);
}

.v-card-text {
    padding-top: 20px;
    padding-bottom: 20px;
}
</style>
