<template>
    <section
        class="partners-section blueprint-grid"
        :style="props.height
            ? { minHeight: props.height, display: 'flex', flexDirection: 'column', justifyContent: 'center', paddingTop: '80px', paddingBottom: '80px' }
            : { paddingTop: '80px', paddingBottom: '80px' }
        "
    >
        <v-container>
            <!-- Section Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <p class="section-eyebrow">Mitra & Klien Kami</p>
                <h2 class="text-h3 font-weight-bold text-primary mb-4">Dipercaya oleh Leaders Automotive</h2>
                <div class="heading-accent mx-auto"></div>
            </div>

            <!-- Our Clients Marquee -->
            <div class="mb-12" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-h6 text-center text-grey-darken-1 mb-6 font-weight-medium">
                    Klien Kami
                </h3>
                <div class="marquee-wrapper">
                    <div ref="clientTrack" class="marquee-track">
                        <div ref="clientContent" class="marquee-content">
                            <img
                                v-for="(logo, i) in clientLogos"
                                :key="'c1-' + i"
                                :src="logo"
                                class="logo-item"
                                :alt="'Logo ' + (i + 1)"
                            />
                        </div>
                        <div class="marquee-content" aria-hidden="true">
                            <img
                                v-for="(logo, i) in clientLogos"
                                :key="'c2-' + i"
                                :src="logo"
                                class="logo-item"
                                :alt="''"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Authorized Distributors Marquee -->
            <div class="mb-12" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-h6 text-center text-grey-darken-1 mb-6 font-weight-medium">
                    Authorized Distributors
                </h3>
                <div class="marquee-wrapper">
                    <div ref="distTrack" class="marquee-track marquee-reverse">
                        <div ref="distContent" class="marquee-content">
                            <img
                                v-for="(logo, i) in distributorLogos"
                                :key="'d1-' + i"
                                :src="logo"
                                class="logo-item"
                                :alt="'Distributor Logo ' + (i + 1)"
                            />
                        </div>
                        <div class="marquee-content" aria-hidden="true">
                            <img
                                v-for="(logo, i) in distributorLogos"
                                :key="'d2-' + i"
                                :src="logo"
                                class="logo-item"
                                :alt="''"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certifications -->
            <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="300">
                <p class="section-eyebrow mb-4">Standar Kualitas</p>
                <h3 class="text-h5 font-weight-bold text-primary mb-8">Sertifikasi Internasional</h3>
                <div class="cert-badges-grid">
                    <div class="cert-badge-card">
                        <div class="cert-icon-wrapper">
                            <v-icon size="32" color="#0D47A1">mdi-certificate</v-icon>
                        </div>
                        <p class="cert-name font-weight-bold mb-1">ISO 9001</p>
                        <p class="cert-desc text-caption text-grey">Quality Management</p>
                    </div>
                    <div class="cert-badge-card">
                        <div class="cert-icon-wrapper">
                            <v-icon size="32" color="#0D47A1">mdi-shield-check</v-icon>
                        </div>
                        <p class="cert-name font-weight-bold mb-1">AS9100D</p>
                        <p class="cert-desc text-caption text-grey">Aerospace Quality</p>
                    </div>
                    <div class="cert-badge-card">
                        <div class="cert-icon-wrapper">
                            <v-icon size="32" color="#0D47A1">mdi-quality-high</v-icon>
                        </div>
                        <p class="cert-name font-weight-bold mb-1">IATF 16949</p>
                        <p class="cert-desc text-caption text-grey">Automotive Quality</p>
                    </div>
                    <div class="cert-badge-card">
                        <div class="cert-icon-wrapper">
                            <v-icon size="32" color="#0D47A1">mdi-star-shooting</v-icon>
                        </div>
                        <p class="cert-name font-weight-bold mb-1">ISO 14001</p>
                        <p class="cert-desc text-caption text-grey">Environmental Mgmt</p>
                    </div>
                </div>
            </div>
        </v-container>
    </section>
</template>


<script setup>
import { onMounted, ref, nextTick, onUnmounted } from 'vue';

const props = defineProps({
    height: {
        type: String,
        default: null,
    },
});

const clientTrack   = ref(null);
const clientContent = ref(null);
const distTrack     = ref(null);
const distContent   = ref(null);

// Animation state
let animationFrame = null;

const clientLogos = [
    '/images/client_logos/1_client_astra-honda-motor.jpg',
    '/images/client_logos/2_client_astra-daihatsu-motor.jpg',
    '/images/client_logos/3_client_mesin-isuzu.jpg',
    '/images/client_logos/4_client_suzuki.jpg',
    '/images/client_logos/5_client_hitachi-astemo.jpg',
    '/images/client_logos/6_client_cheil-jedang.jpg',
    '/images/client_logos/7_client_gm.jpg',
    '/images/client_logos/8_client_dharma.jpg',
];

const distributorLogos = [
    '/images/authorized_distributor_logos/1_audis_wetzel.jpg',
    '/images/authorized_distributor_logos/2_audis_ohmi.jpg',
    '/images/authorized_distributor_logos/3_audis_luvata.jpg',
    '/images/authorized_distributor_logos/4_audis_bibielle.jpg',
    '/images/authorized_distributor_logos/5_audis_xeiwei.jpg',
    '/images/authorized_distributor_logos/6_audis_mytorq.jpg',
    '/images/authorized_distributor_logos/7_audis_posilift-.jpg',
    '/images/authorized_distributor_logos/8_audis_sankyo.jpg',
    '/images/authorized_distributor_logos/9_audis_meech.jpg',
    '/images/authorized_distributor_logos/10_audis_noblift.jpg',
    '/images/authorized_distributor_logos/11_audis_sanyo.jpg',
    '/images/authorized_distributor_logos/12_audis_modular.jpg',
];

onMounted(async () => {
    await nextTick();
    // Wait for images to load
    await waitForImages();
    startMarquee();
});

onUnmounted(() => {
    if (animationFrame) {
        cancelAnimationFrame(animationFrame);
    }
});

function waitForImages() {
    const images = document.querySelectorAll('.logo-item');
    const promises = Array.from(images).map(img => {
        if (img.complete) return Promise.resolve();
        return new Promise(resolve => {
            img.onload = resolve;
            img.onerror = resolve; // Continue even if image fails
        });
    });
    return Promise.all(promises);
}

function startMarquee() {
    const animate = () => {
        // Client marquee
        if (clientTrack.value && clientContent.value) {
            const contentWidth = clientContent.value.offsetWidth;
            const track = clientTrack.value;
            let currentTransform = parseFloat(track.style.transform.replace('translateX(', '').replace('px)', '')) || 0;

            currentTransform -= 0.5; // Speed control

            // Reset when scrolled past content width
            if (Math.abs(currentTransform) >= contentWidth) {
                currentTransform = 0;
            }

            track.style.transform = `translateX(${currentTransform}px)`;
        }

        // Distributor marquee (reverse direction)
        if (distTrack.value && distContent.value) {
            const contentWidth = distContent.value.offsetWidth;
            const track = distTrack.value;
            let currentTransform = parseFloat(track.style.transform.replace('translateX(', '').replace('px)', '')) || 0;

            currentTransform += 0.5; // Reverse direction

            // Reset when scrolled past content width
            if (currentTransform >= 0) {
                currentTransform = -contentWidth;
            }

            track.style.transform = `translateX(${currentTransform}px)`;
        }

        animationFrame = requestAnimationFrame(animate);
    };

    animationFrame = requestAnimationFrame(animate);
}
</script>


<style scoped>
.partners-section {
    background: linear-gradient(180deg, #F8F9FA 0%, #ffffff 100%);
    overflow: hidden;
    position: relative;
}

.heading-accent {
    width: 50px;
    height: 4px;
    background: #D32F2F;
    border-radius: 2px;
}

.marquee-wrapper {
    position: relative;
    overflow: hidden;
    padding: 16px 0;
}

.marquee-wrapper::before,
.marquee-wrapper::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 160px;
    z-index: 2;
    pointer-events: none;
}

.marquee-wrapper::before {
    left: 0;
    background: linear-gradient(to right, #F8F9FA, transparent);
}

.marquee-wrapper::after {
    right: 0;
    background: linear-gradient(to left, #F8F9FA, transparent);
}

.marquee-track {
    display: flex;
    will-change: transform;
}

.marquee-reverse {
    /* Direction handled in JS */
}

.marquee-track:hover .marquee-content {
    /* Smooth pause effect */
}

.marquee-content {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    gap: 64px;
    padding: 8px 32px;
}

.logo-item {
    width: 150px;
    height: 70px;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.6;
    transition: filter 0.4s ease, opacity 0.4s ease, transform 0.3s ease;
    cursor: pointer;
    user-select: none;
    flex-shrink: 0;
}

.logo-item:hover {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.05);
}

/* Certification Badges Grid */
.cert-badges-grid {
    display: flex;
    justify-content: center;
    gap: 32px;
    flex-wrap: wrap;
}

.cert-badge-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 24px 32px;
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    transition: transform var(--transition-base), box-shadow var(--transition-base);
    min-width: 160px;
}

.cert-badge-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-medium);
}

.cert-icon-wrapper {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
    border-radius: 50%;
    margin-bottom: 12px;
}

.cert-name {
    font-size: 1rem;
    color: #0D47A1;
}

.cert-desc {
    font-size: 0.75rem;
    color: #6B7280;
}

/* Responsive */
@media (max-width: 768px) {
    .cert-badges-grid {
        gap: 16px;
    }

    .cert-badge-card {
        min-width: 140px;
        padding: 16px 20px;
    }

    .logo-item {
        width: 120px;
        height: 56px;
    }
}
</style>
