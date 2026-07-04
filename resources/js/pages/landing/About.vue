<template>
    <landing-page-layout id="pages-landing-about">
        <div id="components-landingpage-about">
            <!-- Hero Section -->
            <v-container fluid class="pa-0">
                <v-sheet height="60vh" class="background-image blueprint-grid position-relative">
                    <div class="overlay"></div>
                    <v-row class="fill-height" align="center" justify="center">
                        <v-col cols="12" md="8" lg="6" class="text-white-container text-center px-4" data-aos="fade-up">
                            <p class="section-eyebrow mb-4">Tentang Kami</p>
                            <p class="text-white text-h2 text-uppercase font-weight-bold mb-4">About Us</p>
                            <p class="text-white text-body-1 mx-auto" style="max-width: 600px; line-height: 1.7;">
                                Tim profesional berpengalaman yang berkomitmen memberikan layanan terbaik untuk klien kami sejak 2003.
                            </p>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-container>

            <!-- Main Content -->
            <v-container class="py-16">
                <!-- Services Overview -->
                <v-row class="mb-16">
                    <v-col cols="12">
                        <!-- Section Header -->
                        <div class="text-center mb-10" data-aos="fade-up">
                            <p class="section-eyebrow">Layanan Kami</p>
                            <h2 class="text-h3 font-weight-bold text-primary mb-4">Our Services</h2>
                            <div class="heading-accent mx-auto"></div>
                        </div>

                        <!-- Philosophy Card -->
                        <v-card class="card-elevated rounded-xl pa-8 mb-8" data-aos="fade-up" data-aos-delay="100">
                            <v-row align="center">
                                <v-col cols="12" md="3" class="text-center">
                                    <div class="service-icon-main mb-4">
                                        <v-icon size="48" color="white">mdi-account-group</v-icon>
                                    </div>
                                    <h3 class="text-h5 font-weight-bold text-primary">PT. Techno Triireka</h3>
                                </v-col>
                                <v-col cols="12" md="9">
                                    <p class="text-body-1" style="line-height: 1.8;">
                                        Didirikan pada tahun 2003 sebagai CV Mitra Techno dengan fokus pada bisnis engineering.
                                        Pada Februari 2008, berubah menjadi <strong>PT. Techno Triireka</strong> yang memiliki
                                        dua divisi utama: <strong>Sales Division</strong> dan <strong>Engineering Division</strong>.
                                    </p>
                                </v-col>
                            </v-row>
                        </v-card>

                        <!-- Division Cards -->
                        <v-row>
                            <v-col cols="12" md="6" data-aos="fade-up" data-aos-delay="200">
                                <v-card class="card-elevated rounded-xl pa-6 h-100">
                                    <div class="d-flex align-center mb-4">
                                        <div class="service-icon-wrapper mr-4">
                                            <v-icon size="28" color="white">mdi-shopping</v-icon>
                                        </div>
                                        <h3 class="text-h5 font-weight-bold text-primary">Sales Division</h3>
                                    </div>
                                    <p class="text-body-1 text-grey-darken-1">
                                        Fokus pada penyediaan mesin-mesin industri dan tools yang digunakan di pabrik
                                        automotive. Menyediakan peralatan berkualitas tinggi dari brand-brand ternama
                                        international.
                                    </p>
                                </v-card>
                            </v-col>
                            <v-col cols="12" md="6" data-aos="fade-up" data-aos-delay="300">
                                <v-card class="card-elevated rounded-xl pa-6 h-100">
                                    <div class="d-flex align-center mb-4">
                                        <div class="service-icon-wrapper mr-4">
                                            <v-icon size="28" color="white">mdi-cogs</v-icon>
                                        </div>
                                        <h3 class="text-h5 font-weight-bold text-primary">Engineering Division</h3>
                                    </div>
                                    <p class="text-body-1 text-grey-darken-1">
                                        Fokus pada machining, fabrication, dan design untuk mesin-mesin khusus
                                        di perusahaan automotive. Tim engineer berpengalaman siap membantu
                                        kebutuhan manufacturing Anda.
                                    </p>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>

                <!-- Philosophy Section -->
                <v-row class="py-10 bg-gradient-primary rounded-xl mb-16">
                    <v-col cols="12">
                        <div class="text-center mb-8" data-aos="fade-up">
                            <h2 class="text-h3 font-weight-bold text-white mb-4">Filosofi Perusahaan</h2>
                            <p class="text-white text-body-1 mx-auto" style="max-width: 700px;">
                                Dalam setiap usaha bisnis, kami menilai permintaan pelanggan dengan seksama dan merespons
                                dengan cepat untuk menjaga trilogis Filosofi Perusahaan kami.
                            </p>
                        </div>

                        <v-row justify="center">
                            <v-col cols="12" md="3" v-for="(item, i) in philosophy" :key="i" data-aos="fade-up" :data-aos-delay="(i + 1) * 100">
                                <div class="philosophy-card text-center pa-6">
                                    <v-icon color="#D32F2F" size="40" class="mb-4">{{ item.icon }}</v-icon>
                                    <h4 class="text-h6 font-weight-bold text-primary mb-2">{{ item.title }}</h4>
                                    <p class="text-body-2 text-grey-darken-1">{{ item.desc }}</p>
                                </div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>

                <!-- Mission Section -->
                <v-row class="align-center">
                    <v-col cols="12" md="6" data-aos="fade-up">
                        <p class="section-eyebrow mb-4">Misi Kami</p>
                        <h2 class="text-h3 font-weight-bold text-primary mb-6">Our Mission</h2>
                        <p class="text-body-1 mb-6" style="line-height: 1.8;">
                            Kami berkomitmen menjadi <strong>"Your Truly Global Partner"</strong> dengan memberikan
                            keandalan, kepuasan, dan solusi yang disesuaikan untuk memenuhi berbagai kebutuhan pelanggan.
                        </p>
                        <p class="text-body-1" style="line-height: 1.8;">
                            Kami sangat mementingkan penawaran produk yang ramah lingkungan, selalu berusaha
                            mengusulkan solusi inovatif yang melampaui ekspektasi pelanggan.
                        </p>
                    </v-col>
                    <v-col cols="12" md="6" data-aos="fade-up" data-aos-delay="100">
                        <v-card class="card-elevated rounded-xl pa-8 mission-card">
                            <div class="d-flex align-items-center mb-6">
                                <v-icon size="48" color="#0D47A1" class="mr-4">mdi-bullseye-arrow</v-icon>
                                <h3 class="text-h5 font-weight-bold text-primary">Visi & Nilai</h3>
                            </div>
                            <v-list density="compact">
                                <v-list-item v-for="(value, i) in values" :key="i" class="px-0">
                                    <template #prepend>
                                    <v-icon color="#D32F2F" size="24">mdi-check-circle</v-icon>
                                    </template>
                                    <v-list-item-title class="text-body-1">{{ value }}</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>

            <!-- History Timeline -->
            <v-container fluid class="py-16 bg-grey-lighten-4">
                <v-container>
                    <div class="text-center mb-12" data-aos="fade-up">
                        <p class="section-eyebrow">Perjalanan Kami</p>
                        <h2 class="text-h3 font-weight-bold text-primary mb-4">Company History</h2>
                        <div class="heading-accent mx-auto"></div>
                    </div>

                    <v-timeline side="end" data-aos="fade-up" data-aos-delay="100">
                        <v-timeline-item
                            v-for="(history, index) in histories"
                            :key="index"
                            dot-color="#0D47A1"
                            size="small"
                        >
                            <template #icon>
                                <v-icon color="white" size="small">mdi-star</v-icon>
                            </template>
                            <v-card class="card-elevated rounded-lg pa-4">
                                <div class="d-flex align-center mb-2">
                                    <v-chip color="#D32F2F" size="small" class="font-weight-bold mr-3">
                                        {{ history.date }}
                                    </v-chip>
                                </div>
                                <p class="text-body-2 mb-0">{{ history.project }}</p>
                            </v-card>
                        </v-timeline-item>
                    </v-timeline>
                </v-container>
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
        project: 'CV Mitra Techno telah didirikan dengan fokus pada bisnis engineering'
    },
    {
        date: '2008',
        project: 'CV Mitra Techno berubah menjadi PT. Techno Triireka'
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
        project: 'Penunjukan Authorized Distributor OHMI SEIKI'
    },
    {
        date: '2017 - August',
        project: 'Authorized Distributor HANGCHA & NOBILIFT'
    },
    {
        date: '2022 - November',
        project: 'Authorized Distributor WETZEL, LUVATA, MEECH, SEM INDUSTRY TECHNOLOGY, dan MODULAR'
    },
    {
        date: '2024 - May',
        project: 'Distributor Certification MYTORQ'
    },
]);

const philosophy = ref([
    {
        title: 'Kepuasan Pelanggan',
        icon: 'mdi-emoticon-happy',
        desc: 'Mengutamakan kebutuhan dan harapan pelanggan dalam setiap solusi'
    },
    {
        title: 'Peningkatan Kualitas',
        icon: 'mdi-trending-up',
        desc: 'Terus meningkatkan kualitas produk dan layanan'
    },
    {
        title: 'Originalitas & Inovasi',
        icon: 'mdi-lightbulb',
        desc: 'Mengusulkan solusi kreatif dan inovatif'
    },
    {
        title: 'Komitmen Keberlanjutan',
        icon: 'mdi-leaf',
        desc: 'Produk ramah lingkungan dan solusi berkelanjutan'
    },
]);

const values = ref([
    'Kualitas Produk Premium',
    'Layanan Profesional 24/7',
    'Solusi Custom sesuai Kebutuhan',
    'Pengiriman Tepat Waktu',
    'Harga Kompetitif',
    'Dukungan Teknis Berkelanjutan',
]);
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

.service-icon-wrapper {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0D47A1 0%, #1565C0 100%);
    border-radius: 12px;
    flex-shrink: 0;
}

.service-icon-main {
    width: 88px;
    height: 88px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0D47A1 0%, #1565C0 100%);
    border-radius: 20px;
    margin: 0 auto;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0D47A1 0%, #1565C0 50%, #1976D2 100%);
}

.philosophy-card {
    background: white;
    border-radius: 16px;
    transition: transform var(--transition-base), box-shadow var(--transition-base);
}

.philosophy-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-medium);
}

.mission-card {
    background: linear-gradient(135deg, #F8F9FA 0%, #E8F4FD 100%);
}
</style> 