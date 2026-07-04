<template>
    <v-app-bar
        :class="{
            'transparent-navbar': !isScrolled,
            scrolled: isScrolled,
            'position-fixed': true,
        }"
        color="black"
        app
        id="components-topnavbar"
    >
        <!-- Untuk mobile size kebawah -->
        <v-app-bar-nav-icon v-if="isMobile" @click="mobileMenu = !mobileMenu">
            <v-icon color="white">mdi-menu</v-icon>
        </v-app-bar-nav-icon>

        <!-- Logo untuk mobile -->
        <router-link v-if="isMobile" :to="{ name: 'landing-page' }" class="logo-link-mobile">
            <img src="/images/logo/logo.png" alt="PT. Techno Triireka Logo" height="32" />
        </router-link>

        <v-spacer v-if="!isMobile"></v-spacer>

        <!-- Logo untuk tablet ke atas -->
        <router-link v-if="!isMobile" :to="{ name: 'landing-page' }" class="logo-link">
            <img src="/images/logo/logo.png" alt="PT. Techno Triireka Logo" height="40" />
        </router-link>

        <!-- Menu horizontal di tengah untuk tablet ke atas -->
        <div v-if="!isMobile" class="nav-menu">
            <v-btn
                v-for="(menu, index) in navbarMenus"
                :key="index"
                text
                class="nav-btn"
                :class="{ 'nav-btn-active': isActiveRoute(menu.pathName) }"
                @click="() => $router.push({ name: menu.pathName })"
            >
                {{ menu.title }}
            </v-btn>
        </div>

        <v-spacer v-if="!isMobile"></v-spacer>

        <!-- Jika mobile, menu dropdown akan muncul -->
        <v-overlay v-model="mobileMenu" @click="mobileMenu = false">
            <v-card class="menu-card" @click.stop>
                <v-list>
                    <v-list-item
                        v-for="(menu, index) in navbarMenus"
                        :key="index"
                        @click="() => { $router.push({ name: menu.pathName }); mobileMenu = false; }"
                    >
                        <v-list-item-title>{{ menu.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-overlay>
    </v-app-bar>
</template>


<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { RouterLink, useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();
const mobileMenu = ref(false);
const isMobile = ref(false);
const isScrolled = ref(false);

function handleResize() {
    isMobile.value = window.innerWidth < 960;
}

function handleScroll() {
    isScrolled.value = window.scrollY > 0;
}

function isActiveRoute(pathName) {
    return route.name === pathName;
}

function startEventListener() {
    window.addEventListener("resize", handleResize);
    window.addEventListener("scroll", handleScroll);
    handleResize();
    handleScroll();
}

function stopEventListener() {
    window.removeEventListener("resize", handleResize);
    window.removeEventListener("scroll", handleScroll);
}

const navbarMenus = ref([
    {
        title: "Home",
        path: "/",
        pathName: "landing-page",
    },
    {
        title: "Products",
        path: "/product",
        pathName: "product-list",
    },
    {
        title: "Engineering & Services",
        path: "/engineering-services",
        pathName: "landing-page-engineering-services",
    },
    {
        title: "About Us",
        path: "/about",
        pathName: "landing-page-about",
    },
    {
        title: "Contact",
        path: "/contact",
        pathName: "landing-page-contact",
    },
]);

onMounted(() => {
    startEventListener();
});

onUnmounted(() => {
    stopEventListener();
});
</script>

<style scoped>
.logo-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    padding: 8px 0;
}

.logo-link img {
    height: 40px;
    width: auto;
    filter: brightness(0) invert(1);
    transition: filter 0.3s ease;
}

.logo-link-mobile {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo-link-mobile img {
    height: 32px;
    width: auto;
    filter: brightness(0) invert(1);
}

.nav-menu {
    display: flex;
    align-items: center;
}

.nav-btn {
    color: rgba(255, 255, 255, 0.9) !important;
    font-weight: 500;
    letter-spacing: 0.02em;
    transition: all 0.25s ease;
}

.nav-btn:hover {
    color: #FFFFFF !important;
    background: rgba(255, 255, 255, 0.1) !important;
}

.nav-btn-active {
    color: #D32F2F !important;
    font-weight: 600;
}

.nav-btn-active:hover {
    color: #D32F2F !important;
}

.scrolled .logo-link img,
.scrolled .logo-link-mobile img {
    filter: brightness(0) invert(1);
}

.scrolled .nav-btn {
    color: rgba(255, 255, 255, 0.9) !important;
}

.scrolled .nav-btn:hover {
    color: #FFFFFF !important;
    background: rgba(255, 255, 255, 0.15) !important;
}

.scrolled .nav-btn-active {
    color: #D32F2F !important;
}

.scrolled .nav-btn-active:hover {
    color: #D32F2F !important;
}
</style>
