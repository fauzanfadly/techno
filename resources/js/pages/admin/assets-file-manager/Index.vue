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
                                        <p class="text-h5">Assets Manager Images</p>
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
                                            @click="() => $router.push({ name: 'admin-assets-image-manager-create' })"
                                        >
                                            Create <v-icon>mdi-plus</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-divider class="my-6"></v-divider>
                                <v-row>
                                    <v-col cols="12">
                                        <ImagePicker
                                            @click:image="editItem"
                                        ></ImagePicker>
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
import { onMounted, ref } from 'vue';
import { useUserStore } from '../../../store/user';
import { Request } from '../../../utils/request';
import { openMessage } from '../../../utils/message_dialog';
import { useRouter } from 'vue-router';
import { closeLoading, openLoading } from '../../../utils/loading_dialog';
import ImagePicker from '../../../components/ImagePicker.vue';


const userStore = useUserStore();
const router = useRouter();
const loading = ref(true);
const totalItems = ref(0);
const items = ref([]);
const itemsPerPage = ref(15);


onMounted(() => {
    loadData({ page: 1 });
});

const loadData = async ({ page }) => {
    loading.value = true;

    await Request.get({
        url: `/api/assets-manager/image`,
        data: {
            page,
            items_per_page: itemsPerPage.value,
        },
        errorMessage: `Failed when fetching images`
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

const editItem = ({ id }) => {
    router.push({ name: 'admin-assets-image-manager-detail', params: { id } });
};

const confirmDeleteItem = async (id) => {
    openMessage({
        description: "Are you sure you want to delete this vendor?",
        message: "Delete Vendor",
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
        url: `/api/assets-manager/image/delete/${id}`,
        errorMessage: `Failed to delete image`
    })
    .then(() => {
        loadData({ page: 1 });
    })
    .finally(() => {
        closeLoading();
    });
}
</script>
