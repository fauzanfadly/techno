<template>
    <v-app>
        <router-view></router-view>
    </v-app>
</template>

<script setup>
import { useHead } from "@unhead/vue";
import { RouterView } from "vue-router";

const appName = "PT. Techno Triireka";

useHead({
    titleTemplate: (subTitle) => {
        return subTitle ? `${subTitle} - ${appName}` : appName;
    }
});
</script>
