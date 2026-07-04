<template>
    <landing-page-layout id="pages-landing-index">
        <!-- ================================================
             SECTION 1: SPLIT HERO
             ================================================ -->
        <section class="hero-section">
            <v-container fluid class="pa-0">
                <v-row no-gutters class="fill-height">
                    <!-- Left Side: Content with Blueprint Grid -->
                    <v-col cols="12" md="6" class="hero-content-col">
                        <div class="hero-content-wrapper blueprint-grid">
                            <div class="hero-content" data-aos="fade-right">
                                <!-- Eyebrow -->
                                <span class="eyebrow">Industrial Solutions Since 2003</span>

                                <!-- Main Title -->
                                <h1 class="hero-title">TECHNO TRIIREKA</h1>

                                <!-- Subtitle -->
                                <p class="hero-subtitle">
                                    Your Trusted Global Partner in Engineering & Industrial Solutions.
                                    Delivering top-quality machinery, tools, and custom engineering services
                                    for the automotive industry.
                                </p>

                                <!-- CTA Buttons -->
                                <div class="hero-cta">
                                    <v-btn
                                        size="x-large"
                                        color="accent"
                                        rounded="lg"
                                        class="cta-primary"
                                        @click="() => $router.push({ name: 'landing-page-contact' })"
                                    >
                                        <v-icon start size="20">mdi-phone</v-icon>
                                        Hubungi Kami
                                    </v-btn>
                                    <v-btn
                                        size="x-large"
                                        variant="outlined"
                                        color="white"
                                        rounded="lg"
                                        class="cta-secondary"
                                        @click="() => $router.push({ name: 'landing-page-engineering-services' })"
                                    >
                                        <v-icon start size="20">mdi-cogs</v-icon>
                                        Layanan Engineering
                                    </v-btn>
                                </div>

                                <!-- Trust Indicators -->
                                <div class="trust-indicators">
                                    <div class="trust-item">
                                        <v-icon size="18" color="accent">mdi-certificate</v-icon>
                                        <span>ISO 9001</span>
                                    </div>
                                    <div class="trust-divider"></div>
                                    <div class="trust-item">
                                        <v-icon size="18" color="accent">mdi-shield-check</v-icon>
                                        <span>AS9100D</span>
                                    </div>
                                    <div class="trust-divider"></div>
                                    <div class="trust-item">
                                        <v-icon size="18" color="accent">mdi-quality-high</v-icon>
                                        <span>IATF 16949</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-col>

                    <!-- Right Side: Hero Image -->
                    <v-col cols="12" md="6" class="hero-image-col">
                        <div class="hero-image-wrapper" data-aos="fade-left">
                            <img
                                src="/images/slider_1_1920_1200.jpg"
                                alt="PT. Techno Triireka Industrial Solutions"
                                class="hero-image"
                            />
                            <div class="hero-image-overlay"></div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <!-- ================================================
             SECTION 2: STATS BAR
             ================================================ -->
        <section class="stats-section">
            <v-container fluid class="pa-0">
                <div class="stats-bar">
                    <v-row no-gutters>
                        <v-col cols="6" md="3" v-for="(stat, i) in stats" :key="i">
                            <div
                                class="stat-item"
                                :data-aos="'fade-up'"
                                :data-aos-delay="i * 100"
                            >
                                <div class="stat-icon">
                                    <v-icon size="28" color="white">{{ stat.icon }}</v-icon>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number">{{ stat.number }}</span>
                                    <span class="stat-label">{{ stat.label }}</span>
                                </div>
                            </div>
                        </v-col>
                    </v-row>
                </div>
            </v-container>
        </section>

        <!-- ================================================
             SECTION 3: WHY CHOOSE US
             ================================================ -->
        <section class="why-section py-16">
            <v-container>
                <!-- Section Header -->
                <div class="section-header text-center mb-12" data-aos="fade-up">
                    <span class="eyebrow">Mengapa Memilih Kami</span>
                    <h2 class="section-title">Partner Industrial yang Tepat</h2>
                    <div class="heading-accent mx-auto"></div>
                </div>

                <!-- Why Cards Grid -->
                <v-row>
                    <v-col cols="12" md="4" v-for="(item, i) in whyChooseUs" :key="i">
                        <div
                            class="why-card card-elevated"
                            :data-aos="'fade-up'"
                            :data-aos-delay="(i + 1) * 100"
                        >
                            <div class="why-icon-wrapper">
                                <v-icon size="32" color="white">{{ item.icon }}</v-icon>
                            </div>
                            <h3 class="why-title">{{ item.title }}</h3>
                            <p class="why-desc">{{ item.description }}</p>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <!-- ================================================
             SECTION 4: PRODUCTS SECTION
             ================================================ -->
        <products data-aos="fade-up"></products>

        <!-- ================================================
             SECTION 5: PARTNERS & CERTIFICATIONS
             ================================================ -->
        <partners-section data-aos="fade-up"></partners-section>

        <!-- ================================================
             SECTION 6: ABOUT PREVIEW
             ================================================ -->
        <section class="about-preview-section py-16">
            <v-container>
                <v-row align="center">
                    <v-col cols="12" md="6" data-aos="fade-right">
                        <span class="eyebrow">Tentang Techno Triireka</span>
                        <h2 class="section-title text-left mb-6">20+ Tahun Pengalaman Industrial</h2>
                        <p class="body-text mb-6">
                            Sejak 2003, kami telah membantu perusahaan automotive Indonesia
                            dengan solusi engineering dan supply equipment berkualitas tinggi.
                            Dengan dua divisi utama — Sales dan Engineering — kami berikan
                            layanan yang komprehensif.
                        </p>
                        <v-btn
                            color="primary"
                            size="large"
                            rounded="lg"
                            class="px-8"
                            @click="() => $router.push({ name: 'landing-page-about' })"
                        >
                            Pelajari Lebih Lanjut
                            <v-icon end>mdi-arrow-right</v-icon>
                        </v-btn>
                    </v-col>
                    <v-col cols="12" md="6" data-aos="fade-left">
                        <v-card class="about-preview-card rounded-xl overflow-hidden">
                            <v-img
                                src="/images/engineering-services.jpg"
                                height="400"
                                cover
                            >
                                <template #placeholder>
                                    <div class="d-flex align-center justify-center fill-height bg-grey-lighten-2">
                                        <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                    </div>
                                </template>
                            </v-img>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <!-- ================================================
             SECTION 7: CTA SECTION
             ================================================ -->
        <section class="cta-section">
            <v-container fluid class="pa-0">
                <div class="cta-wrapper blueprint-grid">
                    <div class="cta-overlay"></div>
                    <v-row class="fill-height position-relative" align="center" justify="center">
                        <v-col cols="12" md="8" class="text-center" data-aos="fade-up">
                            <h2 class="cta-title">Siap Menjadi Partner Kami?</h2>
                            <p class="cta-subtitle">
                                Hubungi tim kami untuk konsultasi, penawaran harga, atau diskusi
                                tentang kebutuhan engineering Anda.
                            </p>
                            <v-btn
                                size="x-large"
                                color="accent"
                                rounded="lg"
                                class="cta-btn px-12"
                                @click="() => $router.push({ name: 'landing-page-contact' })"
                            >
                                <v-icon start>mdi-chat</v-icon>
                                Mulai Percakapan
                            </v-btn>
                        </v-col>
                    </v-row>
                </div>
            </v-container>
        </section>
    </landing-page-layout>
</template>

<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import Products from "@/components/LandingPage/Products.vue";
import PartnersSection from "@/components/LandingPage/PartnersSection.vue";
import { onMounted } from "vue";
import AOS from "aos";
import "aos/dist/aos.css";
import { useHead } from "@unhead/vue";

useHead({
    title: 'Home',
});

// Stats Data
const stats = [
    { number: '20+', label: 'Tahun Pengalaman', icon: 'mdi-clock-outline' },
    { number: '500+', label: 'Proyek Selesai', icon: 'mdi-check-circle-outline' },
    { number: '50+', label: 'Mitra Global', icon: 'mdi-earth' },
    { number: '100%', label: 'Komitmen Kualitas', icon: 'mdi-star' },
];

// Why Choose Us Data
const whyChooseUs = [
    {
        icon: 'mdi-handshake',
        title: 'Engineering + Sales',
        description: 'Tidak hanya supplier — kami partner engineering yang ikut desain solusi untuk kebutuhan spesifik Anda.'
    },
    {
        icon: 'mdi-earth',
        title: 'Global Network',
        description: 'Akses ke 50+ brand internasional dengan lokal support Indonesia untuk kemudahan komunikasi dan after-sales service.'
    },
    {
        icon: 'mdi-shield-check',
        title: 'ISO Certified',
        description: 'Quality management system yang terstandar internasional pastikan konsistensi dan reliabilitas produk.'
    },
];

onMounted(() => {
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-out-cubic',
    });
});
</script>

<style scoped>
/* ================================================
   HERO SECTION
   ================================================ */
.hero-section {
    min-height: 100vh;
    display: flex;
}

.hero-content-col {
    background: linear-gradient(135deg, #121212 0%, #1E1E1E 100%);
    display: flex;
    align-items: center;
}

.hero-content-wrapper {
    width: 100%;
    padding: 80px 48px;
}

.hero-content {
    max-width: 560px;
}

.eyebrow {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #D32F2F;
    margin-bottom: 16px;
    padding: 8px 16px;
    background: rgba(211, 47, 47, 0.1);
    border-radius: 4px;
}

.hero-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 900;
    font-size: 3.5rem;
    line-height: 1;
    letter-spacing: 0.05em;
    color: #FFFFFF;
    margin-bottom: 24px;
}

.hero-subtitle {
    font-size: 1.125rem;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 40px;
}

.hero-cta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 48px;
}

.cta-primary {
    font-weight: 600;
    box-shadow: 0 4px 14px rgba(211, 47, 47, 0.4);
}

.cta-primary:hover {
    box-shadow: 0 6px 20px rgba(211, 47, 47, 0.5);
}

.cta-secondary {
    font-weight: 600;
    border-width: 2px;
}

.trust-indicators {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.trust-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
    font-weight: 500;
}

.trust-divider {
    width: 1px;
    height: 20px;
    background: rgba(255, 255, 255, 0.3);
}

/* Hero Image Column */
.hero-image-col {
    position: relative;
}

.hero-image-wrapper {
    height: 100%;
    min-height: 100vh;
    position: relative;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(18, 18, 18, 0.3), transparent);
}

/* ================================================
   STATS SECTION
   ================================================ */
.stats-section {
    margin-top: -1px;
}

.stats-bar {
    background: linear-gradient(90deg, #1565C0 0%, #0D47A1 100%);
    padding: 32px 0;
}

.stat-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 24px;
    border-right: 1px solid rgba(255, 255, 255, 0.1);
}

.stat-item:last-child {
    border-right: none;
}

.stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    color: #FFFFFF;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 4px;
}

/* ================================================
   WHY CHOOSE US SECTION
   ================================================ */
.why-section {
    background: #FAFAFA;
}

.section-header {
    margin-bottom: 48px;
}

.section-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    color: #121212;
    margin-bottom: 16px;
}

.heading-accent {
    width: 50px;
    height: 4px;
    background: #D32F2F;
    border-radius: 2px;
}

.why-card {
    padding: 32px;
    text-align: center;
    height: 100%;
}

.why-icon-wrapper {
    width: 72px;
    height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%);
    border-radius: 16px;
    margin: 0 auto 24px;
}

.why-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.25rem;
    color: #121212;
    margin-bottom: 12px;
}

.why-desc {
    font-size: 1rem;
    color: #6B7280;
    line-height: 1.6;
}

/* ================================================
   ABOUT PREVIEW SECTION
   ================================================ */
.about-preview-section {
    background: #FFFFFF;
}

.body-text {
    font-size: 1.125rem;
    color: #6B7280;
    line-height: 1.8;
}

.about-preview-card {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* ================================================
   CTA SECTION
   ================================================ */
.cta-section {
    min-height: 400px;
}

.cta-wrapper {
    position: relative;
    background: linear-gradient(135deg, #121212 0%, #1E1E1E 100%);
    min-height: 400px;
    display: flex;
    align-items: center;
}

.cta-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at top right, rgba(21, 101, 192, 0.2), transparent 50%),
                radial-gradient(circle at bottom left, rgba(211, 47, 47, 0.15), transparent 50%);
}

.cta-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    color: #FFFFFF;
    margin-bottom: 16px;
}

.cta-subtitle {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 32px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.cta-btn {
    font-weight: 600;
    box-shadow: 0 4px 14px rgba(211, 47, 47, 0.4);
}

/* ================================================
   RESPONSIVE
   ================================================ */
@media (max-width: 960px) {
    .hero-section {
        flex-direction: column;
    }

    .hero-content-col,
    .hero-image-col {
        min-height: auto;
    }

    .hero-content-wrapper {
        padding: 120px 24px 60px;
    }

    .hero-title {
        font-size: 3.5rem;
    }

    .hero-image-wrapper {
        min-height: 50vh;
    }

    .stat-item {
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 600px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .hero-cta {
        flex-direction: column;
    }

    .hero-cta .v-btn {
        width: 100%;
    }

    .trust-indicators {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .trust-divider {
        display: none;
    }

    .cta-title {
        font-size: 1.75rem;
    }
}
</style>
