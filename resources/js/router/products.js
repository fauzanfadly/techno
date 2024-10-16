import Assemble from "@/pages/products/Assemble.vue";
import Painting from "@/pages/products/Painting.vue";
import Weilding from "@/pages/products/Weilding.vue";
import EngineeringServices from "@/pages/products/EngineeringServices.vue";

const routes = [
    {
        path: "/products/assemble",
        name: "products-assemble",
        component: Assemble,
    },
    {
        path: "/products/painting",
        name: "products-painting",
        component: Painting,
    },
    {
        path: "/products/weilding",
        name: "products-weilding",
        component: Weilding,
    },
    {
        path: "/products/engineering-services",
        name: "products-engineering-services",
        component: EngineeringServices,
    },
];

export default routes;
