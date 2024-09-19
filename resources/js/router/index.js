import { createRouter, createWebHistory } from "vue-router";
import App from "@/App.vue";
import landingPage from "./landing-page";

const routes = [...landingPage];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
