<template>
    <top-nav-bar></top-nav-bar>
    <v-main style="margin-top: -55px">
        <slot />
    </v-main>

    <main-footer></main-footer>
</template>

<script setup>
import TopNavBar from "@/components/TopNavBar.vue";
import MainFooter from "@/components/MainFooter.vue";
</script>

<style lang="css" scoped></style>
