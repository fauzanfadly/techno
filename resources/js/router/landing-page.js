import Index from "@/pages/landing/Index.vue";
import EngineeringServices from "@/pages/landing/EngineeringServices.vue";
import About from "@/pages/landing/About.vue";
import Contact from "@/pages/landing/Contact.vue";


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
        component: About,
    },
    {
        path: "/contact",
        name: "landing-page-contact",
        component: Contact,
    },
    {
        path: "/engineering-services",
        name: "landing-page-engineering-services",
        component: EngineeringServices,
    },
];

export default routes;
