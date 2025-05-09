<template>
    <v-app-bar
        :class="{
            'transparent-navbar': !isScrolled,
            scrolled: isScrolled,
            'position-fixed': true,
        }"
        color="black"
        dark
        app
        id="components-topnavbar"
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
        <v-overlay v-model="mobileMenu" @click="mobileMenu = false">
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

const mobileMenu = ref(false);
const isMobile = ref(false);
const isScrolled = ref(false);

function handleResize() {
    isMobile.value = window.innerWidth < 960;
}

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
    startEventListener();
});

onUnmounted(() => {
    stopEventListener();
});
</script>
