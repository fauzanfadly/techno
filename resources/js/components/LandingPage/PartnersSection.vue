<template>
    <section
        class="partners-section"
        :style="props.height
            ? { minHeight: props.height, display: 'flex', flexDirection: 'column', justifyContent: 'center', paddingTop: '60px', paddingBottom: '60px' }
            : { paddingTop: '64px', paddingBottom: '64px' }
        "
    >
        <!-- Our Clients -->
        <div class="mb-14" data-aos="fade-up">
            <p class="text-h5 text-center mb-2">Our Clients</p>
            <div class="heading-accent mx-auto mb-10"></div>
            <div class="marquee-wrapper">
                <div ref="clientTrack" class="marquee-track">
                    <div ref="clientContent" class="marquee-content">
                        <img
                            v-for="(logo, i) in clientLogos"
                            :key="'c1-' + i"
                            :src="logo"
                            class="logo-item"
                        />
                    </div>
                    <div class="marquee-content" aria-hidden="true">
                        <img
                            v-for="(logo, i) in clientLogos"
                            :key="'c2-' + i"
                            :src="logo"
                            class="logo-item"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Authorized Distributors -->
        <div data-aos="fade-up">
            <p class="text-h5 text-center mb-2">Authorized Distributors</p>
            <div class="heading-accent mx-auto mb-10"></div>
            <div class="marquee-wrapper">
                <div ref="distTrack" class="marquee-track marquee-reverse">
                    <div ref="distContent" class="marquee-content">
                        <img
                            v-for="(logo, i) in distributorLogos"
                            :key="'d1-' + i"
                            :src="logo"
                            class="logo-item"
                        />
                    </div>
                    <div class="marquee-content" aria-hidden="true">
                        <img
                            v-for="(logo, i) in distributorLogos"
                            :key="'d2-' + i"
                            :src="logo"
                            class="logo-item"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>


<script setup>
import { onMounted, ref, nextTick } from 'vue';

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
    calibrate(clientTrack.value, clientContent.value);
    calibrate(distTrack.value, distContent.value);
});

function calibrate(track, content) {
    if (!track || !content) return;
    const w = content.getBoundingClientRect().width;
    track.style.setProperty('--scroll-amount', `-${w}px`);
}
</script>


<style scoped>
.partners-section {
    background: #ffffff;
    overflow: hidden;
}

.heading-accent {
    width: 40px;
    height: 3px;
    background: #FF6F00;
    border-radius: 2px;
}

.marquee-wrapper {
    position: relative;
    overflow: hidden;
}

.marquee-wrapper::before,
.marquee-wrapper::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 140px;
    z-index: 2;
    pointer-events: none;
}

.marquee-wrapper::before {
    left: 0;
    background: linear-gradient(to right, #ffffff, transparent);
}

.marquee-wrapper::after {
    right: 0;
    background: linear-gradient(to left, #ffffff, transparent);
}

.marquee-track {
    display: flex;
    will-change: transform;
    animation: marquee-left 28s linear infinite;
}

.marquee-reverse {
    animation-name: marquee-right;
    animation-duration: 32s;
}

.marquee-track:hover {
    animation-play-state: paused;
}

.marquee-content {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    gap: 56px;
    padding: 8px 28px;
}

.logo-item {
    width: 140px;
    height: 64px;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.55;
    transition: filter 0.35s ease, opacity 0.35s ease;
    cursor: pointer;
    user-select: none;
    flex-shrink: 0;
}

.logo-item:hover {
    filter: grayscale(0%);
    opacity: 1;
}

@keyframes marquee-left {
    from { transform: translateX(0); }
    to   { transform: translateX(var(--scroll-amount, -50%)); }
}

@keyframes marquee-right {
    from { transform: translateX(var(--scroll-amount, -50%)); }
    to   { transform: translateX(0); }
}
</style>
