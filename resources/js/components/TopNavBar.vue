<template>
    <v-app-bar
        :class="{ 'transparent-navbar': !isScrolled, scrolled: isScrolled }"
        color="black"
        dark
        app
    >
        <!-- Untuk mobile size kebawah -->
        <v-app-bar-nav-icon v-if="isMobile" @click="mobileMenu = !mobileMenu">
            <v-icon>mdi-menu</v-icon>
        </v-app-bar-nav-icon>

        <v-app-bar-title v-if="isMobile" style="letter-spacing: 3px">
            <router-link
                :to="{ name: 'landing-page' }"
                class="text-white text-decoration-none"
                >TECHNO</router-link
            >
        </v-app-bar-title>

        <v-spacer v-if="!isMobile"></v-spacer>

        <!-- Menu horizontal di tengah untuk tablet ke atas -->
        <v-btn
            v-if="!isMobile"
            v-for="(menu, index) in navbarMenus"
            :key="index"
            text
            class="hover"
            @click="() => $router.push({ name: menu.pathName })"
        >
            {{ menu.title }}
        </v-btn>

        <v-spacer v-if="!isMobile"></v-spacer>

        <!-- Jika mobile, menu dropdown akan muncul -->
        <v-overlay v-if="mobileMenu" @click="mobileMenu = false">
            <v-card class="menu-card" @click.stop>
                <v-list>
                    <v-list-item
                        v-for="(menu, index) in navbarMenus"
                        :key="index"
                        @click="mobileMenu = false"
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
import { RouterLink } from "vue-router";

// ---- Begin::Navbar Functionality ----
// States for controlling mobile menu visibility, screen size check, and scroll position
const mobileMenu = ref(false);
const isMobile = ref(false);
const isScrolled = ref(false);

// Function to check the window size
function handleResize() {
    // Jika ukuran layar di bawah 960px dianggap mobile
    isMobile.value = window.innerWidth < 960;
}

// Function to check scroll position
function handleScroll() {
    isScrolled.value = window.scrollY > 0;
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
// ---- End::Navbar Functionality ----

const navbarMenus = ref([
    {
        title: "Home",
        path: "/",
        pathName: "landing-page",
    },
    {
        title: "Products",
        path: "/products",
        pathName: "landing-page-products",
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
    // Attach event listeners saat komponen dipasang dan lepas ketika komponen dilepas
    startEventListener();
});

onUnmounted(() => {
    stopEventListener();
});
</script>

<style scoped>
.v-app-bar {
    transition: background-color 0.2s ease;
}

.transparent-navbar {
    background-color: rgba(0, 0, 0, 0.5) !important;
    /* Background warna transparan pada posisi awal */
}

.scrolled {
    background-color: rgba(0, 0, 0, 1) !important;
    /* Background warna hitam transparan saat discroll */
}

.menu-card {
    width: 100%;
    max-width: 250px;
    position: fixed;
    top: 56px;
    /* Sesuaikan dengan tinggi navbar */
    left: 50%;
    transform: translateX(-50%);
}
</style>
