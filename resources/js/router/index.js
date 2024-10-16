import { createRouter, createWebHistory } from "vue-router";
import landingPage from "./landing-page";
import products from "./products";

const routes = [
    ...landingPage,
    ...products,
    // test
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
