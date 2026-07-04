<template>
    <landing-page-layout id="pages-engineering-services">
        <!-- Hero Section -->
        <v-container fluid class="pa-0">
            <v-sheet height="60vh" class="background-image-engineering blueprint-grid position-relative">
                <div class="overlay"></div>
                <v-row class="fill-height" align="center" justify="center">
                    <v-col cols="12" md="8" lg="6" class="text-white-container text-center px-4" data-aos="fade-up">
                        <p class="section-eyebrow mb-4">Layanan Kami</p>
                        <p class="text-white text-h2 text-uppercase font-weight-bold mb-4">Engineering & Services</p>
                        <p class="text-white text-body-1 mx-auto" style="max-width: 600px; line-height: 1.7;">
                            Solusi engineering berkualitas tinggi untuk industri automotive dan manufacturing
                        </p>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-container>

        <!-- Services Section -->
        <v-container class="py-16">
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <p class="section-eyebrow">Apa yang Kami Tawarkan</p>
                <h2 class="text-h3 font-weight-bold text-primary mb-4">Layanan Engineering</h2>
                <div class="heading-accent mx-auto mb-4"></div>
                <p class="text-body-1 mx-auto text-grey-darken-1" style="max-width: 700px;">
                    Dengan pengalaman dan keahlian yang luas, kami siap membantu Anda mencapai tujuan produksi optimal.
                </p>
            </div>

            <!-- Services Grid -->
            <v-row>
                <!-- Service Card 1: Jig / Fixtures -->
                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="100">
                    <v-card class="service-card card-elevated h-100" rounded="lg">
                        <v-card-title class="text-h6 font-weight-bold d-flex align-center pb-2">
                            <div class="service-icon-wrapper mr-3">
                                <v-icon size="24" color="white">mdi-wrench</v-icon>
                            </div>
                            Jig / Fixtures
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text class="pt-4">
                            <div v-for="(item, i) in jigFixtures" :key="i" class="d-flex align-start mb-3">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Service Card 2: Assembly S/A Machine -->
                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="200">
                    <v-card class="service-card card-elevated h-100" rounded="lg">
                        <v-card-title class="text-h6 font-weight-bold d-flex align-center pb-2">
                            <div class="service-icon-wrapper mr-3">
                                <v-icon size="24" color="white">mdi-cog-outline</v-icon>
                            </div>
                            Assembly S/A Machine
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text class="pt-4">
                            <div v-for="(item, i) in assemblyMachine" :key="i" class="d-flex align-start mb-3">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Service Card 3: Nut Runner Assembly Machine -->
                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="300">
                    <v-card class="service-card card-elevated h-100" rounded="lg">
                        <v-card-title class="text-h6 font-weight-bold d-flex align-center pb-2">
                            <div class="service-icon-wrapper mr-3">
                                <v-icon size="24" color="white">mdi-robot-industrial</v-icon>
                            </div>
                            Nut Runner Assembly Machine
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text class="pt-4">
                            <div v-for="(item, i) in nutRunnerAssembly" :key="i" class="d-flex align-start mb-3">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Service Card 4: Triming Assembly Line -->
                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="400">
                    <v-card class="service-card card-elevated h-100" rounded="lg">
                        <v-card-title class="text-h6 font-weight-bold d-flex align-center pb-2">
                            <div class="service-icon-wrapper mr-3">
                                <v-icon size="24" color="white">mdi-factory</v-icon>
                            </div>
                            Triming Assembly Line
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text class="pt-4">
                            <div v-for="(item, i) in trimingAssembly" :key="i" class="d-flex align-start mb-3">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Service Card 5: Preparation Line -->
                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="500">
                    <v-card class="service-card card-elevated h-100" rounded="lg">
                        <v-card-title class="text-h6 font-weight-bold d-flex align-center pb-2">
                            <div class="service-icon-wrapper mr-3">
                                <v-icon size="24" color="white">mdi-tools</v-icon>
                            </div>
                            Preparation Line
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text class="pt-4">
                            <div v-for="(item, i) in preparationLine" :key="i" class="d-flex align-start mb-3">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">{{ item }}</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>

                <!-- Service Card 6: Aluminum Profile -->
                <v-col cols="12" md="6" lg="4" data-aos="fade-up" data-aos-delay="600">
                    <v-card class="service-card card-elevated h-100" rounded="lg">
                        <v-card-title class="text-h6 font-weight-bold d-flex align-center pb-2">
                            <div class="service-icon-wrapper mr-3">
                                <v-icon size="24" color="white">mdi-shape-outline</v-icon>
                            </div>
                            Aluminum Profile
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text class="pt-4">
                            <p class="text-body-2 mb-4">Solusi aluminum profile berkualitas tinggi untuk berbagai kebutuhan industri.</p>
                            <div class="d-flex align-start mb-3">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">Custom Fabrication</span>
                            </div>
                            <div class="d-flex align-start mb-3">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">Industrial Grade Material</span>
                            </div>
                            <div class="d-flex align-start">
                                <div class="circle-icon mr-3 mt-1"></div>
                                <span class="text-body-2">Various Sizes Available</span>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <!-- CTA Section -->
            <v-row class="mt-16">
                <v-col cols="12" class="text-center" data-aos="fade-up">
                    <v-card class="cta-card pa-10 rounded-xl" elevation="0">
                        <h3 class="text-h4 font-weight-bold text-primary mb-4">Butuh Solusi Engineering?</h3>
                        <p class="text-body-1 text-grey-darken-1 mb-6 mx-auto" style="max-width: 600px;">
                            Konsultasikan kebutuhan teknis Anda dengan tim ahli kami dan dapatkan solusi terbaik untuk bisnis Anda.
                        </p>
                        <v-btn
                            color="accent"
                            size="x-large"
                            rounded="lg"
                            class="px-10 font-weight-semibold"
                            @click="() => $router.push({ name: 'landing-page-contact' })"
                        >
                            <v-icon start>mdi-phone</v-icon>
                            Hubungi Kami
                        </v-btn>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
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
    background: rgba(0, 0, 0, 0.65);
}

.text-white-container {
    position: relative;
    z-index: 1;
}

.heading-accent {
    width: 50px;
    height: 4px;
    background: #D32F2F;
    border-radius: 2px;
}

.service-card {
    height: 100%;
}

.service-icon-wrapper {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0D47A1 0%, #1565C0 100%);
    border-radius: 10px;
    flex-shrink: 0;
}

.circle-icon {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #D32F2F;
    flex-shrink: 0;
    margin-top: 4px;
}

.cta-card {
    background: linear-gradient(135deg, #F8F9FA 0%, #E8F4FD 100%);
    border: 1px solid #E5E7EB;
}
</style>
