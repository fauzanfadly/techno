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
                                    v-if="scopedVendor && scopedVendor.image"
                                    :src="getStorageFile(scopedVendor.image.file_path)"
                                    max-width="180"
                                    max-height="60"
                                    contain
                                >
                                </v-img>
                            </v-col>
                            <v-col md="8">
                                <span class="eyebrow">Katalog Produk</span>
                                <h1 class="header-title">{{ heroTitle }}</h1>
                                <p class="header-desc">
                                    {{ selectedCategory ? selectedCategory.name : 'Semua Kategori' }}
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
                    <!-- Sidebar: Manufacture, Vendor, Search & Categories -->
                    <v-col cols="12" md="3">
                        <!-- Filters: Manufacture, Vendor, Search -->
                        <v-card class="card-elevated mb-6 pa-4">
                            <div class="filter-header d-flex align-center mb-4">
                                <v-icon size="20" color="primary" class="mr-2">mdi-filter-variant</v-icon>
                                <h3 class="sidebar-title">Filter Produk</h3>
                            </div>

                            <div class="filter-fields d-flex flex-column">
                                <v-select
                                    :model-value="selectedTypeValue"
                                    density="compact"
                                    variant="outlined"
                                    label="Manufaktur"
                                    prepend-inner-icon="mdi-factory"
                                    :items="manufactureOptions"
                                    item-title="name"
                                    item-value="value"
                                    hide-details
                                    color="primary"
                                    @update:modelValue="changeManufacture"
                                />
                                <v-autocomplete
                                    :model-value="selectedVendorValue"
                                    density="compact"
                                    variant="outlined"
                                    label="Distributor"
                                    prepend-inner-icon="mdi-domain"
                                    :items="vendorOptions"
                                    item-title="name"
                                    item-value="id"
                                    hide-details
                                    color="primary"
                                    @update:modelValue="changeVendor"
                                />
                                <v-text-field
                                    v-model="search"
                                    density="compact"
                                    variant="outlined"
                                    label="Cari series"
                                    prepend-inner-icon="mdi-magnify"
                                    clearable
                                    hide-details
                                    color="primary"
                                    @update:modelValue="syncSearchQuery"
                                />
                            </div>
                        </v-card>

                        <!-- Categories -->
                        <v-card class="card-elevated pa-4">
                            <h3 class="sidebar-title mb-4">Kategori</h3>
                            <v-list density="compact" class="category-list">
                                <v-list-item
                                    v-for="category in categoryOptions"
                                    :key="category.key"
                                    :value="category.key"
                                    :active="activeCategoryKey === category.key"
                                    @click="setCategoryParam(category.key)"
                                    class="category-item mb-2"
                                    rounded="lg"
                                >
                                    <template #prepend>
                                        <v-icon size="20" :color="activeCategoryKey === category.key ? 'primary' : 'grey'">
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
                                {{ selectedCategory ? selectedCategory.name : 'Semua Produk' }}
                            </h2>
                            <p class="products-count text-grey">
                                Menampilkan {{ visibleSeries.length }} dari {{ filteredSeries.length }} produk
                            </p>
                        </div>

                        <!-- Loading State -->
                        <v-row v-if="loading">
                            <v-col cols="6" md="3" v-for="n in 8" :key="n">
                                <v-skeleton-loader type="card"></v-skeleton-loader>
                            </v-col>
                        </v-row>

                        <!-- Products Grid -->
                        <template v-else-if="filteredSeries.length > 0">
                            <v-row>
                                <v-col
                                    v-for="(series, index) in visibleSeries"
                                    :key="series.id"
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
                                            <p v-if="!scopedVendor" class="vendor-label text-caption text-grey mt-1 mb-0">
                                                {{ series.vendor_name }}
                                            </p>
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

                            <!-- Infinite scroll sentinel -->
                            <div v-if="hasMore" ref="sentinel" class="scroll-sentinel d-flex justify-center py-8">
                                <v-progress-circular indeterminate color="primary" size="32"></v-progress-circular>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <v-row v-else>
                            <v-col cols="12" class="text-center py-16">
                                <v-icon size="80" color="grey-lighten-1" class="mb-4">mdi-package-variant</v-icon>
                                <template v-if="searchTerm">
                                    <h3 class="text-h5 text-grey mb-2">Tidak ada hasil untuk "{{ searchTerm }}"</h3>
                                    <p class="text-body-2 text-grey mb-4">Coba kata kunci lain atau reset pencarian.</p>
                                    <v-btn color="primary" variant="outlined" @click="resetSearch">
                                        <v-icon start size="16">mdi-close</v-icon>
                                        Reset Pencarian
                                    </v-btn>
                                </template>
                                <template v-else>
                                    <h3 class="text-h5 text-grey mb-2">Tidak Ada Produk</h3>
                                    <p class="text-body-2 text-grey">Silakan pilih kategori lain.</p>
                                </template>
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
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { Request } from "../../../utils/request";
import { getStorageFile } from "../../../utils/storage";
import { useHead } from "@unhead/vue";

const PAGE_SIZE = 24;

const route = useRoute();
const router = useRouter();
const allVendors = ref([]);
const loading = ref(false);
const search = ref(route.query.q || '');
const visibleCount = ref(PAGE_SIZE);
const sentinel = ref(null);
const SCROLL_MARGIN = 200;
let scrollTicking = false;

const searchTerm = computed(() => (search.value || '').trim());

const filterBySearch = (seriesList) => {
    const term = searchTerm.value.toLowerCase();
    if (!term) return seriesList;
    return seriesList.filter(series => (series.name || '').toLowerCase().includes(term));
};

// --- Manufacture (from route :type, 'all' = every manufacture) ---
const manufactureTypes = computed(() => {
    const seen = new Map();
    allVendors.value.forEach(v => {
        const type = v.mt_manufacture_type;
        if (type && !seen.has(type.id)) seen.set(type.id, { id: type.id, name: type.name });
    });
    return [...seen.values()];
});

const selectedType = computed(() => {
    const name = (route.params.type || '').toLowerCase();
    if (!name || name === 'all') return null;
    return manufactureTypes.value.find(t => t.name.toLowerCase() === name) || null;
});

const selectedTypeValue = computed(() => (selectedType.value ? selectedType.value.name : 'all'));

const manufactureOptions = computed(() => [
    { name: 'Semua', value: 'all' },
    ...manufactureTypes.value.map(t => ({ name: t.name, value: t.name })),
]);

// --- Vendor (from route :vendor_id, 'all' = every vendor of the manufacture) ---
const typeVendors = computed(() =>
    selectedType.value
        ? allVendors.value.filter(v => v.mt_manufacture_type_id === selectedType.value.id)
        : allVendors.value
);

const vendorOptions = computed(() => [
    { id: 'all', name: 'Semua' },
    ...typeVendors.value.map(v => ({ id: v.id, name: v.name })),
]);

const scopedVendor = computed(() =>
    typeVendors.value.find(v => String(v.id) === String(route.params.vendor_id)) || null
);

const selectedVendorValue = computed(() => (scopedVendor.value ? scopedVendor.value.id : 'all'));

const scopedVendors = computed(() => (scopedVendor.value ? [scopedVendor.value] : typeVendors.value));

// --- Categories: merged by name across the scoped vendors ---
const categoryGroups = computed(() => {
    const groups = new Map();
    scopedVendors.value.forEach(v => {
        (v.mt_product_category || []).forEach(cat => {
            const key = cat.name.toLowerCase();
            if (!groups.has(key)) groups.set(key, { key: cat.name, name: cat.name, series: [] });
            (cat.mt_product_series || []).forEach(series => {
                groups.get(key).series.push({ ...series, vendor_name: v.name });
            });
        });
    });
    return [...groups.values()];
});

const categoryOptions = computed(() => [
    { key: 'All', name: 'Semua Kategori', series: categoryGroups.value.flatMap(g => g.series) },
    ...categoryGroups.value,
]);

// ?category= holds a category name, or 'All'. Old links with a numeric category id are mapped to its name.
const categoryParam = computed(() => {
    const raw = route.query.category;
    if (!raw || raw === 'All' || raw === 'undefined') return null;
    if (/^\d+$/.test(raw)) {
        for (const v of allVendors.value) {
            const cat = (v.mt_product_category || []).find(c => String(c.id) === raw);
            if (cat) return cat.name;
        }
    }
    return raw;
});

const selectedCategory = computed(() => {
    if (!categoryParam.value) return null;
    return categoryGroups.value.find(g => g.name.toLowerCase() === categoryParam.value.toLowerCase()) || null;
});

const activeCategoryKey = computed(() => (selectedCategory.value ? selectedCategory.value.key : 'All'));

const heroTitle = computed(() => {
    if (scopedVendor.value) return scopedVendor.value.name;
    return selectedType.value ? selectedType.value.name : 'Semua Distributor';
});

const filteredSeries = computed(() =>
    filterBySearch(selectedCategory.value ? selectedCategory.value.series : categoryOptions.value[0].series)
);

function getSeriesCount(category) {
    return filterBySearch(category.series).length;
}

// --- Infinite scroll ---
const visibleSeries = computed(() => filteredSeries.value.slice(0, visibleCount.value));
const hasMore = computed(() => visibleCount.value < filteredSeries.value.length);

// Any filter or search change starts over from the first batch
watch(filteredSeries, () => {
    visibleCount.value = PAGE_SIZE;
});

// Load the next batch while the sentinel is near or above the viewport bottom.
// Position check (not IntersectionObserver) so jumping past the sentinel (End key) still loads.
const loadMoreIfNeeded = async () => {
    while (sentinel.value && hasMore.value
        && sentinel.value.getBoundingClientRect().top < window.innerHeight + SCROLL_MARGIN) {
        visibleCount.value += PAGE_SIZE;
        await nextTick();
    }
};

const onScroll = () => {
    if (scrollTicking) return;
    scrollTicking = true;
    requestAnimationFrame(() => {
        scrollTicking = false;
        loadMoreIfNeeded();
    });
};

// Sentinel (re)appears after data loads or a filter change; the first batch may not fill the screen
watch(sentinel, (el) => {
    if (el) loadMoreIfNeeded();
});

useHead({
    title: computed(() => `${heroTitle.value} Catalog`),
});

// --- Navigation / URL sync ---
const searchQueryValue = () => (searchTerm.value ? { q: searchTerm.value } : {});

const go = ({ type, vendor, category }) => {
    router.push({
        name: 'product-catalog',
        params: { type, vendor_id: vendor },
        query: { category, ...searchQueryValue() },
    });
};

const setCategoryParam = (categoryKey) => {
    go({ type: selectedTypeValue.value, vendor: selectedVendorValue.value, category: categoryKey });
};

const changeManufacture = (typeValue) => {
    go({ type: typeValue || 'all', vendor: 'all', category: 'All' });
};

const changeVendor = (vendorId) => {
    go({ type: selectedTypeValue.value, vendor: vendorId ?? 'all', category: 'All' });
};

// Push search term into the URL so it survives filter changes and reloads
const syncSearchQuery = () => {
    const query = { ...route.query };
    if (searchTerm.value) {
        query.q = searchTerm.value;
    } else {
        delete query.q;
    }
    router.replace({ query });
};

const resetSearch = () => {
    search.value = '';
    syncSearchQuery();
};

const fetchVendors = async () => {
    loading.value = true;
    await Request.get({
        url: '/api/vendor',
        useLoading: true,
    })
        .then(({ data }) => {
            allVendors.value = data.data || [];
        })
        .catch((err) => {})
        .finally(() => {
            loading.value = false;
        });
};

onMounted(async () => {
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });

    await fetchVendors();
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    window.removeEventListener('resize', onScroll);
});

watch(
    () => route.query,
    (newQuery) => {
        // Keep the input in sync with the URL (back/forward navigation)
        if ((newQuery.q || '') !== searchTerm.value) {
            search.value = newQuery.q || '';
        }

        if (route.name === 'product-catalog' && newQuery.category === undefined) {
            router.replace({ query: { ...newQuery, category: 'All' } });
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

.filter-fields {
    gap: 16px;
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

.vendor-label {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
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
