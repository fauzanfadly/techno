<template>
    <DefaultLayout>
        <TopNavBar v-if="useNavbar" />
        <v-main :style="{ marginTop: useNavbar ? '-55px' : '' }">
            <slot></slot>
        </v-main>

        <MainFooter></MainFooter>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/layouts/DefaultLayout.vue";
import TopNavBar from "@/components/TopNavBar.vue";
import MainFooter from "@/components/MainFooter.vue";

defineProps({
    useNavbar: {
        type: Boolean,
        required: false,
        default: true
    }
})
</script>

<style lang="css" scoped></style>
