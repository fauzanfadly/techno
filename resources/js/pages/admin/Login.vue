<template>
    <landing-page-layout :use-navbar="false">
        <v-container fluid class="bg-grey-lighten-2">
            <v-row class="h-100" align="center" justify="center" style="height: 100vh !important;">
                <v-col cols="12" md="6">
                    <v-card>
                        <v-card-title class="text-center text-h4 mb-5">Login</v-card-title>
                        <v-card-text>
                            <v-form ref="form" lazy-validation v-model="isValid">
                                <v-text-field
                                    v-model="email"
                                    label="Email"
                                    :rules="emailRules"
                                    variant="solo"
                                    required
                                    class="mb-5"
                                    @keyup.enter="login"
                                ></v-text-field>

                                <v-text-field
                                    v-model="password"
                                    label="Password"
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append-inner="togglePasswordVisibility"
                                    :rules="passwordRules"
                                    variant="solo"
                                    required
                                    class="mb-5"
                                    @keyup.enter="login"
                                ></v-text-field>

                                <v-btn
                                    @click="login"
                                    color="primary"
                                    block
                                >
                                    Login
                                </v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </landing-page-layout>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { openLoading, closeLoading } from "../../utils/loading_dialog";
import { openSnackbar } from "../../utils/snackbar";
import LandingPageLayout from "@/layouts/LandingPageLayout.vue";
import { useUserStore } from "../../store/user";
import { useRouter } from "vue-router";


const userStore = useUserStore();
const router = useRouter();
const email = ref("xr@mail.com")
const password = ref("123")
const showPassword = ref(false);
const isValid = ref(false);
// const loading = ref(false);
const emailRules = [
    (v) => !!v || "Email is required",
    (v) => /.+@.+\..+/.test(v) || "Email must be valid",
];
const passwordRules = [
    (v) => !!v || "Password is required",
    // (v) => v.length >= 6 || "Password must be at least 6 characters",
];


const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
}

const login = async () => {
    if (!isValid.value) {
        return;
    }

    openLoading();
    let isSuccess = false;
    let message = "Login failed";
    const data = {
        email: email.value,
        password: password.value,
    }

    await axios.post("/api/login", data)
        .then((response) => {
            isSuccess = true;
            message = "Login successful";
            const result = response.data;
            userStore.login({
                id: result.data.id,
                email: result.data.email,
                name: result.data.name,
                token: result.data.token,
                isLoggedIn: true
            });
        })
        .catch((error) => {
            message = `Login failed: ${error}`;
        })
        .finally(() => {
            closeLoading();
            openSnackbar({
                message: message,
                status: isSuccess ? "success" : "error"
            });

            if (userStore.isLoggedIn) {
                router.push({ name: "admin-dashboard" });
            }
        });
};
</script>

<style scoped>
</style>
