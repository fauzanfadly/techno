<template>
    <landing-page-layout id="pages-products-vendor">
        <!-- Hero Section -->
        <section class="hero-section">
            <v-container fluid class="pa-0">
                <v-sheet
                    min-height="50vh"
                    class="background-image blueprint-grid position-relative"
                >
                    <div class="overlay"></div>
                    <v-row class="fill-height" align="center" justify="center">
                        <v-col cols="12" md="10" lg="8" class="text-white-container text-center px-4">
                            <span class="eyebrow">Katalog Produk</span>
                            <h1 class="hero-title">
                                {{ paramType === 'all' ? 'Our Products' : manufactureType.name }}
                            </h1>
                            <p class="hero-subtitle">
                                {{ manufactureType.description || "Jelajahi berbagai produk berkualitas tinggi dari distributor terpercaya. Temukan solusi sempurna untuk kebutuhan manufacturing Anda." }}
                            </p>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-container>
        </section>

        <!-- Product Categories Section -->
        <section class="categories-section py-10">
            <v-container>
                <!-- Section Header -->
                <div class="section-header mb-8" data-aos="fade-up">
                    <span class="eyebrow-dark">Kategori Produk</span>
                    <h2 class="section-title text-left mb-2">Pilih Kategori</h2>
                    <div class="heading-accent"></div>
                </div>

                <!-- Categories Chips -->
                <div class="categories-chips" data-aos="fade-up" data-aos-delay="100">
                    <v-chip-group
                        v-model="paramType"
                        selected-class="chip-active"
                    >
                        <v-chip
                            value="all"
                            @click="$router.push('/product')"
                            class="category-chip"
                            :class="{ 'chip-active': paramType === 'all' }"
                            filter
                            variant="outlined"
                        >
                            <v-icon start size="18">mdi-view-grid</v-icon>
                            All Products
                        </v-chip>
                        <v-chip
                            v-for="(type, index) in manufactureTypes"
                            :key="index"
                            :value="type.name"
                            @click="$router.push(`/product/${type.name}`)"
                            class="category-chip"
                            :class="{ 'chip-active': paramType === type.name }"
                            filter
                            variant="outlined"
                        >
                            <v-icon start size="18">{{ getTypeIcon(type.name) }}</v-icon>
                            {{ type.name }}
                        </v-chip>
                    </v-chip-group>
                </div>
            </v-container>
        </section>

        <v-divider></v-divider>

        <!-- Distributors Section -->
        <section class="distributors-section py-12">
            <v-container>
                <!-- Section Header -->
                <div class="section-header text-center mb-12" data-aos="fade-up">
                    <span class="eyebrow-dark">Distributor & Partner</span>
                    <h2 class="section-title mb-2">Pilih Distributor</h2>
                    <div class="heading-accent mx-auto"></div>
                    <p class="section-desc mx-auto mt-4">
                        Klik distributor di bawah untuk melihat produk-produk yang tersedia.
                    </p>
                </div>

                <!-- Loading State -->
                <v-row v-if="loading" justify="center">
                    <v-col cols="12" sm="6" md="4" v-for="n in 6" :key="n">
                        <v-skeleton-loader type="card" elevation="2"></v-skeleton-loader>
                    </v-col>
                </v-row>

                <!-- Vendors Grid -->
                <v-row v-else-if="vendors.length > 0" justify="center">
                    <v-col
                        v-for="(vendor, index) in vendors"
                        :key="index"
                        cols="12"
                        sm="6"
                        md="4"
                        lg="4"
                    >
                        <v-card
                            class="vendor-card card-elevated"
                            :data-aos="'fade-up'"
                            :data-aos-delay="(index + 1) * 50"
                            @click="$router.push(`/product/catalog/${vendor.mt_manufacture_type ? vendor.mt_manufacture_type.name : 'all'}/${vendor.id}`)"
                        >
                            <!-- Vendor Image -->
                            <div class="vendor-image-wrapper">
                                <v-img
                                    :src="vendor.image ? getStorageFile(vendor.image.file_path) : ''"
                                    height="140"
                                    contain
                                    class="vendor-logo"
                                >
                                    <template #placeholder>
                                        <div class="d-flex align-center justify-center fill-height bg-grey-lighten-2">
                                            <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                        </div>
                                    </template>
                                    <template #error>
                                        <div class="d-flex align-center justify-center fill-height">
                                            <v-icon size="64" color="grey-lighten-1">mdi-domain</v-icon>
                                        </div>
                                    </template>
                                </v-img>

                                <!-- Overlay -->
                                <div class="vendor-overlay">
                                    <v-btn color="accent" size="small" rounded="lg">
                                        <v-icon start size="16">mdi-eye</v-icon>
                                        Lihat Produk
                                    </v-btn>
                                </div>
                            </div>

                            <!-- Vendor Info -->
                            <v-card-text class="pa-4">
                                <h3 class="vendor-name">{{ vendor.name }}</h3>
                                <p class="vendor-type text-caption text-grey mt-1">
                                    {{ vendor.mt_manufacture_type?.name || 'General Products' }}
                                </p>

                                <!-- Categories Preview -->
                                <div class="vendor-categories mt-3" v-if="vendor.mt_product_category?.length">
                                    <v-chip
                                        v-for="(cat, catIndex) in vendor.mt_product_category.slice(0, 3)"
                                        :key="catIndex"
                                        size="x-small"
                                        variant="outlined"
                                        class="mr-1 mb-1"
                                    >
                                        {{ cat.name }}
                                    </v-chip>
                                    <v-chip
                                        v-if="vendor.mt_product_category.length > 3"
                                        size="x-small"
                                        variant="flat"
                                        color="grey-lighten-1"
                                    >
                                        +{{ vendor.mt_product_category.length - 3 }} more
                                    </v-chip>
                                </div>
                            </v-card-text>

                            <!-- Card Footer -->
                            <v-card-actions class="px-4 pb-4">
                                <v-btn
                                    variant="text"
                                    color="primary"
                                    class="px-0"
                                >
                                    Jelajahi
                                    <v-icon end size="18">mdi-arrow-right</v-icon>
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>

                <!-- Empty State -->
                <v-row v-else>
                    <v-col cols="12" class="text-center py-16">
                        <v-icon size="80" color="grey-lighten-1" class="mb-4">mdi-package-variant-closed</v-icon>
                        <h3 class="text-h5 text-grey mb-2">Tidak Ada Distributor</h3>
                        <p class="text-body-2 text-grey">Silakan pilih kategori lain atau hubungi kami.</p>
                    </v-col>
                </v-row>
            </v-container>
        </section>
    </landing-page-layout>
</template>

<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { onMounted, ref, watch } from "vue";
import { Request } from "../../utils/request";
import { useRouter } from "vue-router";
import { getStorageFile } from "../../utils/storage";
import { useHead } from "@unhead/vue";

const router = useRouter();
const paramType = ref('all');
const loading = ref(true);
const manufactureType = ref({});
const vendors = ref([]);
const manufactureTypes = ref([]);

const title = ref(router.currentRoute.value.params.type || 'Our Products');
useHead({ title });

// Category icons mapping
const typeIcons = {
    'Assembly': 'mdi-robot-industrial',
    'Welding': 'mdi-lightning-bolt',
    'Painting': 'mdi-spray',
    'Engineering': 'mdi-cog-outline',
    'Machining': 'mdi-cnc',
    'Quality': 'mdi-check-decagram',
    'Tools': 'mdi-wrench',
    'Equipment': 'mdi-factory',
    'default': 'mdi-package-variant'
};

function getTypeIcon(name) {
    const lowerName = name?.toLowerCase() || '';
    for (const [key, icon] of Object.entries(typeIcons)) {
        if (lowerName.includes(key.toLowerCase())) {
            return icon;
        }
    }
    return typeIcons.default;
}

onMounted(async () => {
    const typeParam = router.currentRoute.value.params.type;

    // Fetch categories first
    await fetchAllManufactureTypes();

    // Check if type param exists and is not 'all'
    if (typeParam && typeParam !== 'all') {
        paramType.value = typeParam;
        await fetchManufactureType();
    } else {
        paramType.value = 'all';
        await fetchAllVendors();
    }
});

const fetchAllManufactureTypes = async () => {
    await Request.get({
        url: "/api/manufacture-type",
        useLoading: false
    })
        .then(({ data }) => {
            manufactureTypes.value = data.data || [];
        })
        .catch((err) => {});
}

const fetchManufactureType = async () => {
    loading.value = true;
    await Request.get({
        url: `/api/manufacture-type/detail/name/${paramType.value}`,
        useLoading: true,
    })
        .then(({ data }) => {
            vendors.value = data.data.mt_vendor || [];
            manufactureType.value = data.data;
        })
        .catch((err) => {})
        .finally(() => {
            loading.value = false;
        });
}

const fetchAllVendors = async () => {
    loading.value = true;
    await Request.get({
        url: "/api/vendor",
        useLoading: true
    })
        .then(({ data }) => {
            vendors.value = data.data || [];
        })
        .catch((err) => {})
        .finally(() => {
            loading.value = false;
        });
}

watch(
    () => router.currentRoute.value.params,
    async (newParams) => {
        // Check if type param exists
        if (newParams.type && newParams.type !== 'all') {
            paramType.value = newParams.type;
            title.value = paramType.value;
            await fetchManufactureType();
        } else {
            // When type is undefined, 'all', or '/product' - fetch all vendors
            paramType.value = 'all';
            title.value = 'Our Products';
            await fetchAllVendors();
        }
    },
    { immediate: true }
);
</script>

<style scoped>
/* Hero Section */
.hero-section {
    margin-top: -64px;
}

.background-image {
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
    background: linear-gradient(135deg, rgba(18, 18, 18, 0.85) 0%, rgba(30, 30, 30, 0.9) 100%);
}

.text-white-container {
    position: relative;
    z-index: 1;
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
    background: rgba(211, 47, 47, 0.15);
    border-radius: 4px;
}

.hero-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 3rem;
    color: #FFFFFF;
    margin-bottom: 16px;
}

.hero-subtitle {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.8);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Section Styles */
.categories-section {
    background: #FAFAFA;
}

.distributors-section {
    background: #FFFFFF;
}

.section-header {
    margin-bottom: 32px;
}

.eyebrow-dark {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #D32F2F;
    margin-bottom: 8px;
}

.section-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    color: #121212;
}

.heading-accent {
    width: 50px;
    height: 4px;
    background: #D32F2F;
    border-radius: 2px;
}

.section-desc {
    font-size: 1rem;
    color: #6B7280;
    max-width: 500px;
}

/* Categories Chips */
.categories-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.category-chip {
    font-weight: 500;
    padding: 8px 20px;
    border-radius: 24px;
    background: white;
    border: 2px solid #E5E7EB;
    transition: all 0.25s ease;
}

.category-chip:hover {
    border-color: #1565C0;
    background: rgba(21, 101, 192, 0.05);
}

.category-chip.chip-active {
    background: #D32F2F;
    border-color: #D32F2F;
    color: white;
}

/* Vendor Cards */
.vendor-card {
    cursor: pointer;
    overflow: hidden;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.vendor-card:hover {
    transform: translateY(-6px);
}

.vendor-image-wrapper {
    position: relative;
    background: linear-gradient(135deg, #F8F9FA 0%, #E8F4FD 100%);
    overflow: hidden;
}

.vendor-logo {
    padding: 16px;
    transition: transform 0.4s ease;
}

.vendor-card:hover .vendor-logo {
    transform: scale(1.05);
}

.vendor-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.vendor-card:hover .vendor-overlay {
    opacity: 1;
}

.vendor-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.125rem;
    color: #121212;
    margin-bottom: 4px;
}

.vendor-type {
    color: #6B7280;
}

.vendor-categories {
    display: flex;
    flex-wrap: wrap;
}

/* Responsive */
@media (max-width: 960px) {
    .hero-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 600px) {
    .hero-title {
        font-size: 2rem;
    }

    .section-title {
        font-size: 1.75rem;
    }

    .categories-chips {
        justify-content: center;
    }
}
</style>
