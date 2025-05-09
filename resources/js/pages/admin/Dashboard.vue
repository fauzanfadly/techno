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
                                        <p class="text-h5 mb-3">Welcome to admin dashboard</p>
                                        <v-btn color="deep-orange" @click="() => logout()">
                                            Logout
                                        </v-btn>
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
import { useUserStore } from '../../store/user';
import { useRouter } from 'vue-router';


const router = useRouter();
const userStore = useUserStore();


const logout = () => {
    userStore.logout();
    if (!userStore.isLoggedIn) {
        router.push({ name: 'admin-login' });
    }
}
</script>
