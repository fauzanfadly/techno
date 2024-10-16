import { useHead } from "@vueuse/head";

const staticPrefix = import.meta.env.VITE_APP_NAME || "APP_NAME";

export const useDynamicTitle = (pageTitle) => {
    useHead({
        title: `${pageTitle} - ${staticPrefix}`,
    });
};
