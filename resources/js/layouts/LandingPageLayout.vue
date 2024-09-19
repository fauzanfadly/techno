<template>
    <top-nav-bar></top-nav-bar>
    <v-main style="margin-top: -55px;">
        <!-- Slot for page content -->
        <slot />
    </v-main>
</template>


<script setup>
import TopNavBar from "@/components/TopNavBar.vue";
</script>


<style lang="css" scoped></style>