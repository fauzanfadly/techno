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
                v-for="(type, index) in manufatureTypes"
                :key="index"
                sm="6"
                md="3"
            >
                <v-hover v-slot="{ isHovering, props }">
                    <v-img
                        v-bind="props"
                        :src="getStorageFile(type.image.image_path)"
                        cover
                        height="200"
                        class="rounded-pill mb-3 user-select-none cursor-pointer"
                        @click="() => $router.push(`/product/${type.name}`)"
                    >
                        <v-overlay
                            :model-value="!!isHovering"
                            class="align-center justify-center"
                            color="black"
                            opacity="0.5"
                            contained
                        >
                            <v-btn
                                size="small"
                                rounded
                                color="orange"
                                v-text="'See More'"
                            />
                        </v-overlay>
                    </v-img>
                </v-hover>
                <p class="text-center text-h5">
                    {{ type.name }}
                </p>
            </v-col>
        </v-row>
    </v-container>
</template>


<script setup>
import { onMounted, ref } from "vue";
import { Request } from "../../utils/request";
import { getStorageFile } from "../../utils/storage";



const manufatureTypes = ref([]);
// const categories = ref([
//     {
//         title: "Assemble",
//         image: "https://www.mytorqtools.com/images/d1-img1.jpg",
//         isHovering: false,
//     },
//     {
//         title: "Painting",
//         image: "https://www.mytorqtools.com/images/d1-img5.jpg",
//         isHovering: false,
//     },
//     {
//         title: "Weilding",
//         image: "https://www.mytorqtools.com/images/d1-img7.jpg",
//         isHovering: false,
//     },
//     {
//         title: "Engineering & Services",
//         image: "https://www.thestreet.com/.image/ar_16:9%2Cc_fill%2Ccs_srgb%2Cg_faces:center%2Cq_auto:good%2Cw_768/MTY3NTM5MzU5MDg3MjczODcw/business-structure-which-type-is-best-for-your-business.png",
//         isHovering: false,
//     },
// ]);


onMounted(async () => {
    await fetchManufactureTypes();
});

const fetchManufactureTypes = async () => {
    await Request.get({
        url: "/api/manufacture-type",
        useLoading: true
    })
        .then(({ data }) => {
            manufatureTypes.value = data.data || [];
        });
}
</script>
