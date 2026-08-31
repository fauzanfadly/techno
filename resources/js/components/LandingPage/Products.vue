<template>
    <section class="products-section">
        <v-container
            class="py-16"
            :style="height ? { minHeight: height } : {}"
        >
            <!-- Section Header -->
            <div class="section-header text-center mb-12" data-aos="fade-up">
                <span class="eyebrow">Katalog Kami</span>
                <h2 class="section-title">Produk & Solusi Industrial</h2>
                <div class="heading-accent mx-auto mb-4"></div>
                <p class="section-desc mx-auto">
                    Pilihan peralatan dan solusi berkualitas tinggi untuk kebutuhan manufacturing automotive Anda.
                </p>
            </div>

            <!-- Products Grid -->
            <v-row v-if="loading">
                <v-col cols="12" sm="6" md="3" v-for="n in 4" :key="n">
                    <v-skeleton-loader type="card" elevation="2"></v-skeleton-loader>
                </v-col>
            </v-row>

            <v-row v-else-if="manufatureTypes.length > 0" justify="center">
                <v-col
                    v-for="(type, index) in manufatureTypes"
                    :key="index"
                    cols="12"
                    sm="6"
                    md="3"
                    lg="3"
                    style="max-width: 320px;"
                >
                    <div
                        class="product-card card-elevated"
                        :data-aos="'fade-up'"
                        :data-aos-delay="(index + 1) * 100"
                    >
                        <!-- Product Image -->
                        <div class="product-image-wrapper">
                            <v-img
                                :src="getStorageFile(type.image?.file_path)"
                                height="200"
                                cover
                                class="product-image"
                            >
                                <template #placeholder>
                                    <div class="d-flex align-center justify-center fill-height bg-grey-lighten-2">
                                        <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                    </div>
                                </template>
                            </v-img>

                            <!-- Overlay on hover -->
                            <div class="product-overlay">
                                <v-btn
                                    size="small"
                                    color="accent"
                                    rounded="lg"
                                    @click="() => $router.push(`/product/${type.name}`)"
                                >
                                    <v-icon start size="16">mdi-eye</v-icon>
                                    Lihat Detail
                                </v-btn>
                            </div>

                            <!-- Category Icon Badge -->
                            <div class="product-icon-badge">
                                <v-icon size="24" color="white">{{ getCategoryIcon(type.name) }}</v-icon>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="product-info pa-4">
                            <h3 class="product-title">{{ type.name }}</h3>
                            <p class="product-desc text-caption text-grey">
                                {{ getCategoryDescription(type.name) }}
                            </p>
                            <div class="product-footer mt-3">
                                <v-btn
                                    variant="text"
                                    color="primary"
                                    size="small"
                                    class="px-0"
                                    @click="() => $router.push(`/product/${type.name}`)"
                                >
                                    Selengkapnya
                                    <v-icon end size="16">mdi-arrow-right</v-icon>
                                </v-btn>
                            </div>
                        </div>
                    </div>
                </v-col>
            </v-row>

            <!-- Empty State -->
            <v-row v-else>
                <v-col cols="12" class="text-center py-16">
                    <v-icon size="64" color="grey-lighten-1" class="mb-4">mdi-package-variant</v-icon>
                    <p class="text-h6 text-grey">Produk sedang dalam pembaruan</p>
                    <p class="text-body-2 text-grey">Silakan hubungi kami untuk informasi produk terbaru.</p>
                </v-col>
            </v-row>

            <!-- CTA Button -->
            <v-row v-if="manufatureTypes.length > 0" class="mt-8">
                <v-col cols="12" class="text-center" data-aos="fade-up">
                    <v-btn
                        size="large"
                        variant="outlined"
                        color="primary"
                        rounded="lg"
                        class="px-10"
                        @click="() => $router.push({ name: 'product-list' })"
                    >
                        <v-icon start>mdi-view-grid</v-icon>
                        Lihat Semua Produk
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { Request } from "../../utils/request";
import { getStorageFile } from "../../utils/storage";

const props = defineProps({
    height: {
        type: String,
        default: null,
    },
});

const manufatureTypes = ref([]);
const loading = ref(true);

// Category icons mapping
const categoryIcons = {
    'Assembly': 'mdi-robot-industrial',
    'Welding': 'mdi-lightning-bolt',
    'Painting': 'mdi-spray',
    'Engineering': 'mdi-cog-outline',
    'Machining': 'mdi-cnc',
    'Quality': 'mdi-check-decagram',
    'Tools': 'mdi-wrench',
    'Equipment': 'mdi-factory',
};

// Category descriptions
const categoryDescriptions = {
    'Assembly': 'Assembly line equipment & jigs untuk automotive manufacturing.',
    'Welding': 'Solusi welding modern untuk production efficiency.',
    'Painting': 'Sistem painting & coating untuk finish berkualitas.',
    'Engineering': 'Custom engineering solutions untuk kebutuhan khusus.',
    'Machining': 'Mesin machining presisi tinggi.',
    'Quality': 'Equipment untuk quality control & testing.',
    'Tools': 'Hand tools & power tools untuk factory floor.',
    'Equipment': 'Industrial equipment & machinery.',
};

function getCategoryIcon(name) {
    const lowerName = name.toLowerCase();
    for (const [key, icon] of Object.entries(categoryIcons)) {
        if (lowerName.includes(key.toLowerCase())) {
            return icon;
        }
    }
    return 'mdi-cog'; // default icon
}

function getCategoryDescription(name) {
    const lowerName = name.toLowerCase();
    for (const [key, desc] of Object.entries(categoryDescriptions)) {
        if (lowerName.includes(key.toLowerCase())) {
            return desc;
        }
    }
    return 'Solusi industrial berkualitas untuk automotive industry.';
}

onMounted(async () => {
    await fetchManufactureTypes();
});

const fetchManufactureTypes = async () => {
    loading.value = true;
    await Request.get({
        url: "/api/manufacture-type",
        useLoading: true
    })
        .then(({ data }) => {
            manufatureTypes.value = data.data || [];
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>

<style scoped>
.products-section {
    background: #FAFAFA;
}

.section-header {
    margin-bottom: 48px;
}

.eyebrow {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #D32F2F;
    margin-bottom: 12px;
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

.section-desc {
    font-size: 1.125rem;
    color: #6B7280;
    max-width: 600px;
}

/* Product Card */
.product-card {
    overflow: hidden;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-8px);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
}

.product-image {
    transition: transform 0.4s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-icon-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%);
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(21, 101, 192, 0.3);
}

.product-info {
    background: white;
}

.product-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.125rem;
    color: #121212;
    margin-bottom: 8px;
}

.product-desc {
    line-height: 1.5;
    color: #6B7280;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Responsive */
@media (max-width: 960px) {
    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 600px) {
    .section-title {
        font-size: 1.75rem;
    }
}
</style>
