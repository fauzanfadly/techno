import { createRouter, createWebHistory } from "vue-router";
import landingPage from "./landing-page";
import products from "./products";
import admin from "./admin";
import { useUserStore } from "../store/user";

const routes = [
    ...landingPage,
    ...products,
    ...admin,
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const isAuthenticated = () => {
    const userStore = useUserStore();
    return userStore.isLoggedIn;
}

router.beforeEach((to, from, next) => {
    if (!to.meta.auth && !to.meta.guest) {
        return next();
    }

    if (to.meta.auth && !isAuthenticated()) {
        return next({ name: 'admin-login' });
    }

    if (to.meta.guest && isAuthenticated()) {
        return next({ name: 'admin-dashboard' });
    }

    return next();
});

 
const _scrollTopPaths = ['/', '/product', '/engineering-services', '/about', '/contact'];

router.afterEach((to) => {
    if (_scrollTopPaths.includes(to.path)) {
        // scroll to top smoothly when navigating to specific pages
        if (typeof window !== 'undefined' && window.scrollTo) {
            window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
        }
    }
});

export default router;
