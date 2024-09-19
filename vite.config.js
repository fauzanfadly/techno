import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vuetify from "@vuetify/vite-plugin";

const env = process.env;

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
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
    server: {
        port: env.VITE_PORT ? parseInt(env.VITE_PORT) : 3000,
    },
    resolve: {
        alias: {
            "@": "/resources/js",
        },
    },
});
