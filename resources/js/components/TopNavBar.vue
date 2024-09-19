<template>
    <v-app-bar :class="{ 'transparent-navbar': !isScrolled, 'scrolled': isScrolled }" color="black" dark app>
        <!-- Untuk mobile size kebawah -->
        <v-app-bar-nav-icon v-if="isMobile" @click="mobileMenu = !mobileMenu">
            <v-icon>mdi-menu</v-icon>
        </v-app-bar-nav-icon>

        <v-spacer v-if="!isMobile"></v-spacer>

        <!-- Menu horizontal di tengah untuk tablet ke atas -->
        <v-btn v-if="!isMobile" text>Home</v-btn>
        <v-btn v-if="!isMobile" text>About</v-btn>
        <v-btn v-if="!isMobile" text>Contact</v-btn>

        <v-spacer v-if="!isMobile"></v-spacer>

        <!-- Jika mobile, menu dropdown akan muncul -->
        <v-overlay v-if="mobileMenu" @click="mobileMenu = false">
            <v-card class="menu-card" @click.stop>
                <v-list>
                    <v-list-item @click="mobileMenu = false">
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="mobileMenu = false">
                        <v-list-item-title>About</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="mobileMenu = false">
                        <v-list-item-title>Contact</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-overlay>
    </v-app-bar>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// States for controlling mobile menu visibility, screen size check, and scroll position
const mobileMenu = ref(false);
const isMobile = ref(false);
const isScrolled = ref(false);

// Function to check the window size
const handleResize = () => {
    // Jika ukuran layar di bawah 960px dianggap mobile
    isMobile.value = window.innerWidth < 960;
};

// Function to check scroll position
const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

// Attach event listeners saat komponen dipasang dan lepas ketika komponen dilepas
onMounted(() => {
    window.addEventListener('resize', handleResize);
    window.addEventListener('scroll', handleScroll);
    handleResize(); // Untuk inisialisasi pertama kali
    handleScroll(); // Untuk inisialisasi pertama kali
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.v-app-bar {
    transition: background-color 0.3s ease;
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