<template>
    <landing-page-layout id="pages-products-catalog-index">
        <!-- Hero/Header Section -->
        <section class="header-section pt-10">
            <v-container fluid class="pa-0">
                <v-sheet class="header-sheet blueprint-grid position-relative">
                    <div class="header-overlay"></div>
                    <v-container class="position-relative" style="z-index: 2;">
                        <v-row align="center" class="py-8">
                            <v-col md="4">
                                <v-img
                                    v-if="vendor && vendor.image"
                                    :src="getStorageFile(vendor.image.file_path)"
                                    max-width="180"
                                    max-height="60"
                                    contain
                                    class="vendor-logo"
                                >
                                </v-img>
                            </v-col>
                            <v-col md="8">
                                <span class="eyebrow">Katalog Produk</span>
                                <h1 class="header-title">{{ vendor?.name || 'Catalog' }}</h1>
                                <p class="header-desc">
                                    {{ getCategoryByParam ? getCategoryByParam.name : 'Semua Kategori' }}
                                </p>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-sheet>
            </v-container>
        </section>

        <!-- Main Content -->
        <section class="content-section py-12">
            <v-container>
                <v-row>
                    <!-- Sidebar: Vendor Selector & Categories -->
                    <v-col cols="12" md="3">
                        <!-- Vendor Selector -->
                        <v-card class="card-elevated mb-6 pa-4">
                            <h3 class="sidebar-title mb-4">Pilih Distributor</h3>
                            <v-autocomplete
                                v-model="selectVendor"
                                density="compact"
                                variant="outlined"
                                label="Distributor"
                                :items="manufactureType.mt_vendor || []"
                                item-title="name"
                                item-value="id"
                                return-object
                                hide-details=""
                                color="primary"
                                @update:modelValue="changeVendor"
                            />
                        </v-card>

                        <!-- Categories -->
                        <v-card class="card-elevated pa-4">
                            <h3 class="sidebar-title mb-4">Kategori</h3>
                            <v-list density="compact" class="category-list">
                                <v-list-item
                                    v-for="(category, index) in productCategory"
                                    :key="index"
                                    :value="category.id"
                                    :active="(paramCategoryId || 'All') === category.id"
                                    @click="setCategoryParam(category.id)"
                                    class="category-item mb-2"
                                    rounded="lg"
                                >
                                    <template #prepend>
                                        <v-icon size="20" :color="(paramCategoryId || 'All') === category.id ? 'primary' : 'grey'">
                                            mdi-folder-outline
                                        </v-icon>
                                    </template>
                                    <v-list-item-title class="category-item-title">
                                        {{ category.name }}
                                    </v-list-item-title>
                                    <template #append>
                                        <v-chip
                                            size="x-small"
                                            variant="flat"
                                            color="grey-lighten-1"
                                        >
                                            {{ getSeriesCount(category) }}
                                        </v-chip>
                                    </template>
                                </v-list-item>
                            </v-list>
                        </v-card>
                    </v-col>

                    <!-- Products Grid -->
                    <v-col cols="12" md="9">
                        <!-- Products Header -->
                        <div class="products-header mb-6">
                            <h2 class="products-title">
                                {{ getCategoryByParam ? getCategoryByParam.name : 'Semua Produk' }}
                            </h2>
                            <p class="products-count text-grey">
                                {{ getProductSeries.length }} produk ditemukan
                            </p>
                        </div>

                        <!-- Loading State -->
                        <v-row v-if="loading">
                            <v-col cols="6" md="3" v-for="n in 8" :key="n">
                                <v-skeleton-loader type="card"></v-skeleton-loader>
                            </v-col>
                        </v-row>

                        <!-- Products Grid -->
                        <v-row v-else-if="getProductSeries.length > 0">
                            <v-col
                                v-for="(series, index) in getProductSeries"
                                :key="index"
                                cols="6"
                                md="3"
                            >
                                <v-card
                                    class="product-card card-elevated"
                                    :data-aos="'fade-up'"
                                    :data-aos-delay="(index % 4) * 50"
                                >
                                    <!-- Product Image -->
                                    <div class="product-image-wrapper">
                                        <v-img
                                            height="160"
                                            cover
                                            :src="series.image ? getStorageFile(series.image.file_path) : ''"
                                            class="product-image"
                                        >
                                            <template #placeholder>
                                                <div class="d-flex align-center justify-center fill-height bg-grey-lighten-2">
                                                    <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                                </div>
                                            </template>
                                            <template #error>
                                                <div class="d-flex align-center justify-center fill-height">
                                                    <v-icon size="64" color="grey-lighten-1">mdi-image-off-outline</v-icon>
                                                </div>
                                            </template>
                                        </v-img>

                                        <!-- PDF Badge -->
                                        <v-chip
                                            v-if="series.no_pdf"
                                            class="no-pdf-badge"
                                            color="error"
                                            size="small"
                                        >
                                            <v-icon start size="12">mdi-file-document-remove</v-icon>
                                            Katalog Tidak Tersedia
                                        </v-chip>
                                    </div>

                                    <!-- Product Info -->
                                    <v-card-text class="pa-3">
                                        <h4 class="product-name">{{ series.name }}</h4>
                                    </v-card-text>

                                    <!-- Product Actions -->
                                    <v-card-actions class="px-3 pb-3">
                                        <v-btn
                                            v-if="!series.no_pdf"
                                            color="primary"
                                            size="small"
                                            variant="flat"
                                            :href="series.file ? getStorageFile(series.file.file_path) : ''"
                                            target="_blank"
                                            class="flex-grow-1"
                                        >
                                            <v-icon start size="16">mdi-file-pdf-box</v-icon>
                                            Lihat PDF
                                        </v-btn>
                                        <v-btn
                                            v-else
                                            color="info"
                                            size="small"
                                            variant="outlined"
                                            to="/contact"
                                            target="_blank"
                                            class="flex-grow-1"
                                        >
                                            <v-icon start size="16">mdi-file-document-remove</v-icon>
                                            Hubungi Kami
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>

                        <!-- Empty State -->
                        <v-row v-else>
                            <v-col cols="12" class="text-center py-16">
                                <v-icon size="80" color="grey-lighten-1" class="mb-4">mdi-package-variant</v-icon>
                                <h3 class="text-h5 text-grey mb-2">Tidak Ada Produk</h3>
                                <p class="text-body-2 text-grey">Silakan pilih kategori lain.</p>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </section>
    </landing-page-layout>
</template>

<script setup>
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { computed, onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import { Request } from "../../../utils/request";
import { getStorageFile } from "../../../utils/storage";
import { useHead } from "@unhead/vue";

const router = useRouter();
const paramType = ref(null);
const paramVendorId = ref(null);
const vendor = ref(null);
const manufactureType = ref({ name: 'Manufacture' });
const productCategory = ref([]);
const selectedCategoryId = ref(null);
const categoryAll = { name: 'Semua Kategori', id: 'All' };
const selectVendor = ref(null);
const loading = ref(false);

useHead({
    title: 'Catalog'
});

const paramCategoryId = computed(() => {
    const category = router.currentRoute.value.query.category;
    // Return null for "All" or undefined, otherwise return the category id
    if (!category || category === 'All') return null;
    return (!isNaN(parseInt(category)) ? parseInt(category) : category);
});

const getProductSeries = computed(() => {
    let tempSeries = [];

    if (paramCategoryId.value) {
        // Filter by specific category
        const category = productCategory.value.find(cat => cat.id === paramCategoryId.value);
        if (category && category.mt_product_series) {
            tempSeries = [...category.mt_product_series];
        }
    } else {
        // Show all products from all categories
        productCategory.value.forEach(cat => {
            if (cat.id !== 'All' && cat.mt_product_series) {
                tempSeries.push(...cat.mt_product_series);
            }
        });
    }

    return tempSeries;
});

const getCategoryByParam = computed(() => {
    if (!paramCategoryId.value) return null;
    return productCategory.value.find(item => item.id === paramCategoryId.value) || null;
});

function getSeriesCount(category) {
    // For "All" category, return total count
    if (category.id === 'All') {
        let total = 0;
        productCategory.value.forEach(cat => {
            if (cat.id !== 'All' && cat.mt_product_series) {
                total += cat.mt_product_series.length;
            }
        });
        return total;
    }
    return category.mt_product_series?.length || 0;
}

onMounted(async () => {
    await onMountedAction();
});

const onMountedAction = async () => {
    paramType.value = router.currentRoute.value.params.type || null;
    paramVendorId.value = router.currentRoute.value.params.vendor_id || null;

    if (paramType.value && paramVendorId.value) {
        await fetchVendor();
        selectVendor.value = vendor.value?.id;
        useHead({
            title: `${vendor.value?.name || 'Catalog'} Catalog`
        });
    } else {
        router.back();
    }

    if (!router.currentRoute.value.query.category) {
        setCategoryParam('All');
    }
};

const setCategoryParam = (categoryId) => {
    selectedCategoryId.value = categoryId;
    router.push(`/product/catalog/${manufactureType.value.name}/${paramVendorId.value}?category=${categoryId}`);
};

const changeVendor = async (_vendor) => {
    await router.push(`/product/catalog/${paramType.value}/${_vendor.id}?category=All`);
    await onMountedAction();
};

const fetchVendor = async () => {
    loading.value = true;
    await Request.get({
        url: `/api/vendor/detail/${paramVendorId.value}`,
        useLoading: true,
    })
        .then(({ data }) => {
            vendor.value = data.data;
            manufactureType.value = data.data.mt_manufacture_type;
            productCategory.value = [
                categoryAll,
                ...data.data.mt_product_category
            ];
        })
        .catch((err) => {})
        .finally(() => {
            loading.value = false;
        });
};

watch(
    () => router.currentRoute.value.query,
    (newQuery) => {
        if (newQuery.category === undefined) {
            return router.back();
        }

        if (newQuery.category === 'undefined') {
            return router.push(`/product/catalog/${paramType.value}/${paramVendorId.value}?category=All`);
        }
    },
    { immediate: true }
);
</script>

<style scoped>
/* Header Section */
.header-sheet {
    background: linear-gradient(135deg, #121212 0%, #1E1E1E 100%);
    min-height: 180px;
}

.header-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at top right, rgba(21, 101, 192, 0.2), transparent 50%);
}

.vendor-logo {
    filter: brightness(0) invert(1);
}

.eyebrow {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #D32F2F;
    margin-bottom: 8px;
}

.header-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    color: #FFFFFF;
    margin-bottom: 8px;
}

.header-desc {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.7);
}

/* Sidebar */
.sidebar-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1rem;
    color: #121212;
}

.category-list {
    background: transparent;
}

.category-item {
    border-radius: 8px;
    transition: background 0.2s ease;
}

.category-item:hover {
    background: rgba(21, 101, 192, 0.05);
}

.category-item-title {
    font-weight: 500;
    font-size: 0.875rem;
}

/* Products */
.products-header {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    padding-bottom: 16px;
    border-bottom: 2px solid #E5E7EB;
}

.products-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    color: #121212;
}

.products-count {
    font-size: 0.875rem;
}

.product-card {
    overflow: hidden;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-4px);
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

.no-pdf-badge {
    position: absolute;
    top: 8px;
    right: 8px;
}

.product-name {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.875rem;
    color: #212121;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

/* Responsive */
@media (max-width: 960px) {
    .header-title {
        font-size: 1.5rem;
    }

    .products-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
