import Vendor from "@/pages/products/Vendor.vue";
import ProductCatalog from "@/pages/products/catalog/Index.vue";

const routes = [
    {
        path: "/product/catalog/:type/:vendor_id",
        name: "product-catalog",
        component: ProductCatalog,
    },
    {
        path: "/product/:type",
        name: "product-type",
        component: Vendor,
    },
    {
        path: "/product",
        name: "product-list",
        component: Vendor,
    },
];

export default routes;
