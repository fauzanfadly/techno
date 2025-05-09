<template>
    <v-app>
        <slot />
        <MessageDialog />
        <LoadingDialog />
        <SnackBar />
        <ImageFullScreenDialog />
    </v-app>
</template>

<script setup>
import MessageDialog from "@/components/dialogs/MessageDialog.vue";
import LoadingDialog from "@/components/dialogs/LoadingDialog.vue";
import SnackBar from "@/components/dialogs/SnackBar.vue";
import ImageFullScreenDialog from "@/components/dialogs/ImageFullScreenDialog.vue";
import { useHead } from "@unhead/vue";

useHead({
    titleTemplate: (subTitle) => {
        return subTitle ? `${subTitle} - Techno` : 'Techno';
    }
})
</script>
