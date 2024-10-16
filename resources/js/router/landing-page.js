import Index from "@/pages/landing/Index.vue";

const routes = [
    {
        path: "/",
        name: "landing-page",
        component: Index,
    },
    {
        path: "/products",
        name: "landing-page-products",
        component: Index,
    },
    {
        path: "/about",
        name: "landing-page-about",
        component: Index,
    },
    {
        path: "/contact",
        name: "landing-page-contact",
        component: Index,
    },
];

export default routes;
