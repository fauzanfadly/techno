import Index from "@/pages/landing/Index.vue";
import About from "@/pages/landing/About.vue";
import Contact from "@/pages/landing/Contact.vue";

const routes = [
    {
        path: "/",
        name: "landing-page",
        component: Index,
    },
    {
        path: "/about",
        name: "landing-page-about",
        component: About,
    },
    {
        path: "/contact",
        name: "landing-page-contact",
        component: Contact,
    },
];

export default routes;
