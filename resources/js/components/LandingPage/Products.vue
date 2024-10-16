<template>
    <v-container
        :style="{
            'padding-top': '30vh',
            'padding-bottom': '30vh',
        }"
    >
        <v-row align="center" justify="center">
            <v-col>
                <p class="text-h4 text-center mb-0">Products</p>
            </v-col>
        </v-row>
        <v-divider class="mb-10 mt-5"></v-divider>
        <v-row align="center" justify="center">
            <v-col
                v-for="(category, index) in categories"
                :key="index"
                sm="6"
                md="3"
            >
                <v-img
                    :src="category.image"
                    cover
                    height="200"
                    class="rounded-pill mb-3 user-select-none cursor-pointer"
                    @mouseenter="() => (category.isHovering = true)"
                    @mouseleave="() => (category.isHovering = false)"
                    @click="() => $router.push({ name: category.to })"
                >
                    <v-overlay
                        :model-value="!!category.isHovering"
                        class="align-center justify-center"
                        color="black"
                        opacity="0.5"
                        contained
                    >
                        <v-btn size="small" rounded color="orange"
                            >See More</v-btn
                        >
                    </v-overlay>
                </v-img>
                <p class="text-center text-h5">
                    {{ category.title }}
                </p>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from "vue";

const categories = ref([
    {
        title: "Assemble",
        image: "https://www.mytorqtools.com/images/d1-img1.jpg",
        to: "products-assemble",
        isHovering: false,
    },
    {
        title: "Painting",
        image: "https://www.mytorqtools.com/images/d1-img5.jpg",
        to: "products-painting",
        isHovering: false,
    },
    {
        title: "Weilding",
        image: "https://www.mytorqtools.com/images/d1-img7.jpg",
        to: "products-weilding",
        isHovering: false,
    },
    {
        title: "Engineering & Services",
        image: "https://www.thestreet.com/.image/ar_16:9%2Cc_fill%2Ccs_srgb%2Cg_faces:center%2Cq_auto:good%2Cw_768/MTY3NTM5MzU5MDg3MjczODcw/business-structure-which-type-is-best-for-your-business.png",
        to: "products-engineering-services",
        isHovering: false,
    },
]);
</script>

<style scoped></style>
