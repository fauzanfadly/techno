<template>
    <default-layout>
        <!-- Top Navbar -->
        <v-app-bar app>
            <v-app-bar-nav-icon @click="() => changeDrawer()" />
            <v-toolbar-title>Admin Dashboard</v-toolbar-title>
        </v-app-bar>

        <!-- Sidebar Drawer -->
        <v-navigation-drawer
            v-model="drawer"
            app
            color="orange-lighten-4"
        >
            <!-- Menu Items -->
            <v-list density="compact">
                <v-list-item
                    v-for="(menu, index) in sidebarMenus"
                    :key="index"
                    link
                    @click="() => movePage({ pathName: menu.pathName })"
                >
                    <template #prepend>
                        <v-icon color="deep-orange-darken-4">{{ menu.icon }}</v-icon>
                    </template>
                    <v-list-item-title>{{ menu.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- Main Content -->
        <v-main class="bg-grey-lighten-3">
            <slot></slot>
        </v-main>
    </default-layout>
</template>


<script setup>
import { useRouter } from "vue-router";
import DefaultLayout from "./DefaultLayout.vue";
import { onMounted, ref } from "vue";

const router = useRouter();
const drawer = ref(false);
const sidebarMenus = ref([
    {
        title: "Home",
        icon: "mdi-home-outline",
        pathName: "admin-dashboard",
    },
    {
        title: "Product",
        icon: "mdi-package",
        pathName: "admin-product-list",
    },
    {
        title: "Product Series",
        icon: "mdi-package-variant",
        pathName: "admin-product-series-list",
    },
    {
        title: "Product Category",
        icon: "mdi-package-variant-closed",
        pathName: "admin-product-category-list",
    },
    {
        title: "Vendor",
        icon: "mdi-handshake-outline",
        pathName: "admin-vendor-list",
    },
    {
        title: "Manufacture Type",
        icon: "mdi-factory",
        pathName: "admin-manufacture-type-list",
    },
    {
        title: "Images Manager",
        icon: "mdi-folder-multiple-image",
        pathName: "admin-assets-image-manager-list",
    },
    {
        title: "Files Manager",
        icon: "mdi-file-multiple",
        pathName: "admin-assets-file-manager-list",
    },
]);


onMounted(() => {
    changeDrawer(window.innerWidth >= 960)
})


const changeDrawer = (value = !drawer.value) => {
    drawer.value = value
}

const movePage = ({ url = "", pathName = "" }) => {
    if (url) {
        return router.push(url)
    }

    if (pathName) {
        return router.push({ name: pathName })
    }
}
</script>
