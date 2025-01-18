import Vendor from "@/pages/products/Vendor.vue";
import ProductCatalog from "@/pages/products/catalog/Index.vue";

const routes = [
    {
        path: "/product/:type",
        name: "product",
        component: Vendor,
    },
    {
        path: "/product/catalog/:type/:vendor_id",
        name: "product-catalog",
        component: ProductCatalog,
    },
];

export default routes;
