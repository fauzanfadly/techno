<template>
    <v-app>
        <router-view></router-view>
    </v-app>
</template>

<script setup>
import { RouterView } from "vue-router";
</script>

<style lang="scss">
$body-font-family: "Poppins", sans-serif !important;
$heading-font-family: "Poppins", sans-serif !important;
$font-family: "Poppins", sans-serif !important;

@import url("../css/app.css");
</style>
