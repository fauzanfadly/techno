import Login from '@/pages/admin/Login.vue';
import Dashboard from '@/pages/admin/Dashboard.vue';
import ProductList from '@/pages/admin/product/Index.vue';
import ProductForm from '@/pages/admin/product/Form.vue';
import ProductSeriesList from '@/pages/admin/product-series/Index.vue';
import ProductSeriesForm from '@/pages/admin/product-series/Form.vue';
import ProductCategoryList from '@/pages/admin/product-category/Index.vue';
import ProductCategoryForm from '@/pages/admin/product-category/Form.vue';
import VendorList from '@/pages/admin/vendor/Index.vue';
import VendorForm from '@/pages/admin/vendor/Form.vue';
import ManufactureTypeList from '@/pages/admin/manufacture-type/Index.vue';
import ManufactureTypeForm from '@/pages/admin/manufacture-type/Form.vue';
import AssetsFileManagerList from '@/pages/admin/assets-file-manager/Index.vue';


const routes = [
    {
        path: "/admin/login",
        name: "admin-login",
        component: Login,
        meta: {
            guest: true
        }
    },
    {
        path: "/admin/dashboard",
        name: "admin-dashboard",
        component: Dashboard,
        meta: {
            auth: true
        }
    },


    // ---- PRODUCT ----
    {
        path: "/admin/product",
        name: "admin-product-list",
        component: ProductList,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/product/create",
        name: "admin-product-create",
        component: ProductForm,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/product/detail/:id",
        name: "admin-product-detail",
        component: ProductForm,
        meta: {
            auth: true
        }
    },
    // ---- PRODUCT ----


    // ---- PRODUCT SERIES ----
    {
        path: "/admin/product-series",
        name: "admin-product-series-list",
        component: ProductSeriesList,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/product-series/create",
        name: "admin-product-series-create",
        component: ProductSeriesForm,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/product-series/detail/:id",
        name: "admin-product-series-detail",
        component: ProductSeriesForm,
        meta: {
            auth: true
        }
    },
    // ---- PRODUCT SERIES ----


    // ---- PRODUCT CATEGORY ----
    {
        path: "/admin/product-category",
        name: "admin-product-category-list",
        component: ProductCategoryList,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/product-category/create",
        name: "admin-product-category-create",
        component: ProductCategoryForm,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/product-category/detail/:id",
        name: "admin-product-category-detail",
        component: ProductCategoryForm,
        meta: {
            auth: true
        }
    },
    // ---- PRODUCT CATEGORY ----


    // ---- VENDOR ----
    {
        path: "/admin/vendor",
        name: "admin-vendor-list",
        component: VendorList,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/vendor/create",
        name: "admin-vendor-create",
        component: VendorForm,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/vendor/detail/:id",
        name: "admin-vendor-detail",
        component: VendorForm,
        meta: {
            auth: true
        }
    },
    // ---- VENDOR ----


    // ---- MANUFACTURE TYPE ----
    {
        path: "/admin/manufacture-type",
        name: "admin-manufacture-type-list",
        component: ManufactureTypeList,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/manufacture-type/create",
        name: "admin-manufacture-type-create",
        component: ManufactureTypeForm,
        meta: {
            auth: true
        }
    },
    {
        path: "/admin/manufacture-type/detail/:id",
        name: "admin-manufacture-type-detail",
        component: ManufactureTypeForm,
        meta: {
            auth: true
        }
    },
    // ---- MANUFACTURE TYPE ----


    // ---- ASSETS FILE MANAGER ----
    {
        path: "/admin/assets-file-manager",
        name: "admin-assets-file-manager-list",
        component: AssetsFileManagerList,
        meta: {
            auth: true
        }
    },
    // ---- ASSETS FILE MANAGER ----
];

export default routes;
