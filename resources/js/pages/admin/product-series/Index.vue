<template>
    <div>
        <dashboard-layout>
            <v-container>
                <v-row>
                    <v-col md="12">
                        <v-card>
                            <v-container>
                                <v-row>
                                    <v-col md="12">
                                        <p class="text-h5">Product Series</p>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col md="12">
                                        <v-divider></v-divider>
                                    </v-col>
                                </v-row>
                                <v-row justify="end">
                                    <v-col cols="auto">
                                        <v-btn
                                            color="deep-orange"
                                            @click="() => $router.push({ name: 'admin-product-series-create' })"
                                        >
                                            Create <v-icon>mdi-plus</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col md="12">
                                        <v-data-table-server
                                            v-model:items-per-page="itemsPerPage"
                                            :headers="headers"
                                            :items="items"
                                            :items-length="totalItems"
                                            :loading="loading"
                                            loading-text="Please wait, loading your data..."
                                            item-value="name"
                                            @update:options="loadData"
                                        >
                                            <template #item.actions="{ item }">
                                                <v-btn
                                                    color="blue"
                                                    class="me-3"
                                                    icon="mdi-pencil"
                                                    density="compact"
                                                    @click="editItem(item.id)"
                                                />
                                                <v-btn
                                                    color="red"
                                                    icon="mdi-delete"
                                                    density="compact"
                                                    @click="confirmDeleteItem(item.id)"
                                                />
                                            </template>
                                        </v-data-table-server>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </dashboard-layout>
    </div>
</template>


<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { ref } from 'vue';
import { useUserStore } from '../../../store/user';
import { Request } from '../../../utils/request';
import { openMessage } from '../../../utils/message_dialog';
import { useRouter } from 'vue-router';
import { closeLoading, openLoading } from '../../../utils/loading_dialog';


const userStore = useUserStore();
const router = useRouter();
const headers = ref([
    {
        title: 'Id',
        key: 'id',
        width: '5%',
    },
    {
        title: 'Name',
        key: 'name',
        width: '25%',
    },
    {
        title: 'Description',
        key: 'description',
    },
    {
        title: 'Category',
        key: 'mt_product_category.name',
        width: '15%',
    },
    {
        title: 'Vendor',
        key: 'mt_product_category.mt_vendor.name',
        width: '15%',
    },
    {
        title: 'Manufacture Type',
        key: 'mt_product_category.mt_vendor.mt_manufacture_type.name',
        width: '15%',
    },
    {
        title: 'Actions',
        key: 'actions',
        width: '100px',
        sortable: false,
    },
]);
const loading = ref(true);
const totalItems = ref(0);
const items = ref([]);
const itemsPerPage = ref(15);


const loadData = async ({ page }) => {
    loading.value = true;

    await Request.get({
        url: `/api/product/series`,
        data: {
            page,
            items_per_page: itemsPerPage.value,
        },
        errorMessage: `Failed when fetching product series`
    })
        .then(({ data }) => {
            const result = data.data;
            items.value = result.data;
            totalItems.value = result.total || result.length;
            itemsPerPage.value = result.per_page;
        })
        .finally(() => {
            loading.value = false;
        });
};

const editItem = (id) => {
    router.push({ name: 'admin-product-series-detail', params: { id } });
};

const confirmDeleteItem = async (id) => {
    openMessage({
        description: "Are you sure you want to delete this product series?",
        message: "Delete Product Series",
        icon: "mdi-delete-alert",
        iconColor: "red",
        actionButtons: [
            {
                color: "gray",
                text: "Cancel"
            },
            {
                color: "red",
                text: "Delete",
                action: () => {
                    deleteItem(id);
                }
            }
        ]
    });
};

const deleteItem = async (id) => {
    openLoading();
    await Request.del({
        url: `/api/product/series/delete/${id}`,
        errorMessage: `Failed to delete product series`
    })
    .then(() => {
        loadData({ page: 1 });
    })
    .finally(() => {
        closeLoading();
    });
}
</script>
