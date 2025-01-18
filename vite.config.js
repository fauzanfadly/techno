import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vuetify from "@vuetify/vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/scss/variables.scss",
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // css: {
    //     preprocessorOptions: {
    //         scss: {
    //             additionalData: `@import "@/../scss/variables.scss";`,
    //         },
    //     },
    // },
    server: {
        host: process.env.VITE_PORT || "localhost",
        port: parseInt(process.env.VITE_PORT || '3000'),
    },
    resolve: {
        alias: {
            "@": "/resources/js",
        },
    },
});
