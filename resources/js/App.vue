<template>
    <v-app>
        <router-view></router-view>
    </v-app>
</template>

<script setup>
import { useHead } from "@unhead/vue";
import { RouterView } from "vue-router";

const appName = "Techno";

useHead({
    titleTemplate: (subTitle) => {
        return subTitle ? `${subTitle} - ${appName}` : appName;
    }
});
</script>
